<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontenController extends Controller
{
    // Ambil konfigurasi seksi sekaligus memeriksa izin peran (admin: semua, guru: seksi_guru)
    private function cfg(string $s): array
    {
        $cfg = config("admin_menu.seksi.$s");
        abort_if($cfg === null, 404);
        abort_unless(auth('admin')->user()->bolehKonten($s), 403);

        return $cfg;
    }

    public function index(string $s)
    {
        $cfg = $this->cfg($s);

        return view('admin.crud', [
            's' => $s,
            'fields' => $cfg['fields'],
            'pakaiUrutan' => $s !== 'berita',
            'daftar' => Konten::seksi($s)->get(),
            'pageKey' => $s,
            'pageTitle' => $cfg['judul'],
            'pageDesc' => "Kelola konten halaman {$cfg['halaman']}.",
        ]);
    }

    public function store(Request $request, string $s)
    {
        $cfg = $this->cfg($s);
        DB::transaction(function () use ($request, $cfg, $s): void {
            $data = $this->validasi($request, $cfg['fields'], $s);
            Konten::create(['seksi' => $s, ...$data]);
        });

        return redirect()->route('admin.konten.index', $s)->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, string $s, Konten $konten)
    {
        $cfg = $this->cfg($s);
        abort_unless($konten->seksi === $s, 404);
        DB::transaction(function () use ($request, $cfg, $s, $konten): void {
            $item = Konten::whereKey($konten->getKey())->lockForUpdate()->firstOrFail();
            $data = $this->validasi($request, $cfg['fields'], $s, $item);
            $gambarLama = $item->gambar;
            $item->update($data);
            if (isset($data['gambar'])) {
                Upload::hapus($gambarLama);
            }
        });

        return redirect()->route('admin.konten.index', $s)->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $s, Konten $konten)
    {
        $this->cfg($s);
        abort_unless($konten->seksi === $s, 404);
        DB::transaction(function () use ($konten): void {
            $item = Konten::whereKey($konten->getKey())->lockForUpdate()->firstOrFail();
            $item->delete();
            Upload::hapus($item->gambar);
        });

        return redirect()->route('admin.konten.index', $s)->with('success', 'Data berhasil dihapus.');
    }

    // Validasi dinamis berdasarkan config/admin_menu.php
    private function validasi(Request $request, array $fields, string $s, ?Konten $konten = null): array
    {
        $rules = ['urutan' => ['nullable', 'integer']];

        foreach ($fields as $f) {
            $wajib = $f['wajib'] ? 'required' : 'nullable';
            $rules[$f['k']] = match ($f['tipe']) {
                'image' => [$f['wajib'] && ! $konten ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:3072'],
                'star' => [$wajib, 'integer', 'between:1,5'],
                'date' => [$wajib, 'date'],
                'area' => [$wajib, 'string'],
                default => [$wajib, 'string', 'max:255'],
            };
        }

        $valid = $request->validate($rules);
        $data = [];

        foreach ($fields as $f) {
            $k = $f['k'];
            if ($f['tipe'] === 'image') {
                if ($request->hasFile($k)) {
                    $data['gambar'] = Upload::simpan($request->file($k));
                }

                continue;
            }
            $v = $valid[$k] ?? null;
            $data[$k] = match ($f['tipe']) {
                'date', 'area' => $v,
                'star' => (int) ($v ?? 0),
                default => $v ?? '',
            };
        }

        if ($s !== 'berita') {
            $data['urutan'] = (int) ($valid['urutan'] ?? 0);
        }

        return $data;
    }
}
