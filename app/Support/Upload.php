<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Upload
{
    const DIR = 'img/uploads';

    public static function simpan(UploadedFile $file): string
    {
        $nama = Str::random(24).'.'.$file->guessExtension();
        DB::table('media_uploads')->insert([
            'nama' => $nama,
            'mime' => $file->getMimeType(),
            'data' => base64_encode($file->getContent()),
        ]);

        return self::DIR.'/'.$nama;
    }

    public static function hapus(?string $path): void
    {
        if ($path && str_starts_with($path, self::DIR.'/')) {
            DB::table('media_uploads')->where('nama', basename($path))->delete();
        }
    }

    public static function tampil(string $nama): Response
    {
        $gambar = DB::table('media_uploads')->where('nama', $nama)->first();
        abort_if($gambar === null, 404);

        return response(base64_decode($gambar->data), 200, [
            'Content-Type' => $gambar->mime,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
