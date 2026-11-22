<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('auth.initial_admin_password');
        if (! is_string($password) || strlen($password) < 16 || strlen($password) > 72) {
            throw new \RuntimeException('ADMIN_INITIAL_PASSWORD harus berisi 16 sampai 72 byte.');
        }

        Admin::firstOrCreate(
            ['username' => 'admin'],
            ['password' => $password, 'nama' => 'Administrator']
        );
    }
}
