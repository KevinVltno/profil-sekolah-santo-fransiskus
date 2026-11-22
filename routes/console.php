<?php

use Dotenv\Dotenv;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('school:import-supabase', function (): int {
    if (! is_file(base_path('.env.supabase'))) {
        $this->error('Simpan DB_URL di .env.supabase sebelum mengimpor.');

        return 1;
    }

    $settings = Dotenv::parse(file_get_contents(base_path('.env.supabase')));
    $url = $settings['DB_URL'] ?? '';
    $parts = parse_url($url);
    if (! $parts || ! in_array($parts['scheme'] ?? '', ['postgres', 'postgresql'], true)
        || ! str_ends_with($parts['host'] ?? '', '.pooler.supabase.com')
        || ($parts['port'] ?? null) !== 5432 || empty($parts['user']) || empty($parts['pass'])) {
        $this->error('DB_URL harus memakai URL PostgreSQL dari Supabase Session pooler (port 5432).');

        return 1;
    }

    $source = DB::connection();
    if ($source->getDriverName() === 'pgsql') {
        $this->error('Jalankan impor sebelum mengalihkan koneksi utama ke Supabase.');

        return 1;
    }

    $admins = $source->table('admins')->get()->map(function (object $admin) use ($settings): array {
        if (Hash::check('admin123', $admin->password)) {
            $replacement = $settings['ADMIN_INITIAL_PASSWORD'] ?? '';
            if (strlen($replacement) < 16 || strlen($replacement) > 72) {
                throw new RuntimeException('Isi ADMIN_INITIAL_PASSWORD yang baru (16–72 byte) di .env.supabase.');
            }

            $admin->password = Hash::make($replacement);
        }

        $admin->remember_token = null;

        return (array) $admin;
    })->all();

    config(['database.connections.supabase_import' => [
        ...config('database.connections.pgsql'),
        'url' => $url,
        'search_path' => 'school',
        'sslmode' => 'require',
    ]]);

    $status = $this->call('migrate', ['--database' => 'supabase_import', '--force' => true]);
    if ($status !== 0) {
        return $status;
    }

    $target = DB::connection('supabase_import');
    $tables = ['admins' => 'id', 'konten' => 'id', 'pengaturan' => 'kunci'];
    if ($source->getSchemaBuilder()->hasTable('media_uploads')) {
        $tables['media_uploads'] = 'nama';
    }

    $target->transaction(function () use ($source, $target, $admins, $tables): void {
        foreach ($tables as $table => $key) {
            if ($target->table($table)->exists()) {
                throw new RuntimeException("Impor dibatalkan karena tabel {$table} di Supabase sudah berisi data.");
            }

            if ($table === 'admins') {
                if ($admins !== []) {
                    $target->table($table)->insert($admins);
                }
            } else {
                $source->table($table)->orderBy($key)->chunk($table === 'media_uploads' ? 5 : 100, function ($rows) use ($target, $table): void {
                    $target->table($table)->insert($rows->map(fn (object $row): array => (array) $row)->all());
                });
            }

            if ($key === 'id') {
                $maxId = $target->table($table)->max('id');
                if ($maxId !== null) {
                    $target->selectOne("select setval(pg_get_serial_sequence(?, 'id'), ?)", [$table, $maxId]);
                }
            }
        }
    });

    foreach (array_keys($tables) as $table) {
        $this->info("{$table}: ".$target->table($table)->count().' baris di Supabase.');
    }

    return 0;
})->purpose('Copy existing school data to an empty Supabase schema');
