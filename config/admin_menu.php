<?php

// Satu-satunya tempat mendefinisikan menu & kolom form dashboard.
// Tipe field: text | area | image | date | star
$f = fn ($k, $label, $tipe = 'text', $wajib = false) => compact('k', 'label', 'tipe', 'wajib');
$m = fn ($halaman, $ikon, $judul, $fields) => compact('halaman', 'ikon', 'judul', 'fields');

$fIkon  = $f('ikon', 'Ikon (nama Font Awesome, mis. fa-trophy)');
$fFoto  = fn ($l = 'Foto', $w = true) => $f('gambar', $l, 'image', $w);
$fJudul = fn ($l = 'Judul', $w = true) => $f('judul', $l, 'text', $w);
$fTeks  = fn ($l = 'Tulisan', $w = true) => $f('teks', $l, 'area', $w);

return [
    // Seksi konten yang boleh dikelola akun berperan guru (admin boleh semua)
    'seksi_guru' => ['berita', 'beranda_galeri', 'profil_ekskul', 'profil_prestasi'],

    'seksi' => [
        'beranda_tumbuh'     => $m('Beranda', 'fa-image', 'Logo Sekolah', [$fFoto('Logo Sekolah')]),
        'beranda_sejarah'    => $m('Beranda', 'fa-scroll', 'Sejarah Sekolah', [$fFoto('Foto', false), $fJudul(), $fTeks()]),
        'beranda_keunggulan' => $m('Beranda', 'fa-trophy', 'Keunggulan', [$fIkon, $fJudul(), $fTeks()]),
        'beranda_galeri'     => $m('Beranda', 'fa-images', 'Galeri', [$fFoto(), $fJudul('Keterangan')]),
        'beranda_testimoni'  => $m('Beranda', 'fa-comments', 'Testimonial', [
            $f('bintang', 'Bintang', 'star', true),
            $fTeks('Isi Testimoni (keterangan)'),
            $fJudul('Nama Orang'),
            $fFoto('Foto Profil Orang', false),
            $f('teks2', 'Keterangan Orang Tua Murid (mis. Orang tua murid kelas 1)'),
        ]),
        'beranda_faq'        => $m('Beranda', 'fa-circle-question', 'FAQ', [$fJudul('Pertanyaan'), $fTeks('Jawaban Singkat')]),

        'profil_sejarah'     => $m('Profil Sekolah', 'fa-scroll', 'Sejarah Sekolah', [$fFoto('Foto', false), $fJudul(), $fTeks()]),
        'profil_keunggulan'  => $m('Profil Sekolah', 'fa-trophy', 'Keunggulan', [$fIkon, $fJudul(), $fTeks()]),
        'profil_ekskul'      => $m('Profil Sekolah', 'fa-drum', 'Ekstrakurikuler', [$fFoto(), $fJudul('Nama Ekskul')]),
        'profil_prestasi'    => $m('Profil Sekolah', 'fa-award', 'Prestasi', [
            $fFoto('Gambar'),
            $fJudul('Judul Prestasi'),
            $f('teks2', 'Keterangan (mis. Tingkat Kabupaten Sragen)'),
            $f('tahun', 'Tahun'),
            $f('ikon', 'Medali (mis. fa-medal medal-gold, medal-silver, atau medal-bronze)'),
        ]),
        'profil_visimisi'    => $m('Profil Sekolah', 'fa-bullseye', 'Visi & Misi', [
            $fJudul('Bagian (tulis persis: Visi atau Misi)'),
            $fTeks('Tulisan (Misi: satu poin per baris)'),
        ]),

        'guru_bersama'       => $m('Profil Guru', 'fa-users', 'Foto Bersama', [$fFoto(), $fJudul('Judul'), $f('teks2', 'Keterangan')]),
        'guru_staf'          => $m('Profil Guru', 'fa-chalkboard-user', 'Guru & Staf', [
            $fFoto(), $fJudul('Nama'), $f('teks2', 'Jabatan', 'text', true), $f('teks', 'Pendidikan'),
        ]),

        'fasilitas'          => $m('Fasilitas', 'fa-school', 'Fasilitas', [$fFoto(), $fJudul('Nama Fasilitas'), $fTeks('Keterangan', false)]),
        'program'            => $m('Program', 'fa-star', 'Program Unggulan', [$fFoto(), $fJudul('Nama Program'), $fTeks('Keterangan', false)]),
        'berita'             => $m('Berita', 'fa-newspaper', 'Berita', [
            $fFoto(), $fJudul(), $f('tanggal', 'Tanggal', 'date', true), $fTeks('Keterangan / Isi Berita'),
        ]),
    ],

    // Pengaturan tunggal (satu form per halaman), khusus admin. Tipe: text | area | image | wa | maps | url | email
    'pengaturan' => [
        'kontak' => $m('Hubungi Kami', 'fa-phone', 'Hubungi Kami', [
            $f('kontak_alamat', 'Alamat', 'area'),
            $f('kontak_telepon', 'No. Telepon'),
            $f('kontak_whatsapp', 'WhatsApp (0819… / 62819…)', 'wa'),
            $f('kontak_email', 'Email', 'email'),
            $f('kontak_jam', 'Jam Operasional'),
            $f('kontak_gmaps', 'Google Maps (kode iframe / URL embed)', 'maps'),
            $f('kontak_ig', 'Link Instagram', 'url'),
            $f('kontak_fb', 'Link Facebook', 'url'),
            $f('kontak_yt', 'Link YouTube', 'url'),
            $f('kontak_tt', 'Link TikTok', 'url'),
        ]),
        'footer' => $m('Footer', 'fa-shoe-prints', 'Footer', [
            $f('footer_logo', 'Logo Footer', 'image'),
            $f('footer_deskripsi', 'Deskripsi', 'area'),
            $f('footer_ig', 'Link Instagram', 'url'),
            $f('footer_yt', 'Link YouTube', 'url'),
            $f('footer_fb', 'Link Facebook', 'url'),
            $f('footer_tt', 'Link TikTok', 'url'),
        ]),
        'hero' => $m('Beranda', 'fa-heading', 'Teks Utama Beranda', [
            $f('hero_badge', 'Tulisan Label Kecil (mis. Penerimaan Siswa Baru)'),
            $f('hero_judul1', 'Judul Baris 1 – Putih (mis. Tumbuh & Berkembang)'),
            $f('hero_judul2', 'Judul Baris 2 – Biru Muda (mis. Bersama Santo Fransiskus)'),
            $f('hero_deskripsi', 'Deskripsi di Bawah Judul', 'area'),
            $f('hero_tombol1', 'Tulisan Tombol Putih (mis. Daftar via WhatsApp)'),
            $f('hero_tombol2', 'Tulisan Tombol Garis (mis. Kenali Kami)'),
        ]),
        'statistik' => $m('Beranda', 'fa-chart-simple', 'Kotak Statistik', [
            $f('stat1_angka', 'Kotak 1 – Tulisan Besar (mis. 1968)'),
            $f('stat1_label', 'Kotak 1 – Keterangan (mis. Tahun Berdiri)'),
            $f('stat2_angka', 'Kotak 2 – Tulisan Besar (mis. A)'),
            $f('stat2_label', 'Kotak 2 – Keterangan (mis. Akreditasi BAN-S/M)'),
            $f('stat3_angka', 'Kotak 3 – Tulisan Besar (mis. 1–6)'),
            $f('stat3_label', 'Kotak 3 – Keterangan (mis. Jenjang Kelas)'),
            $f('stat4_angka', 'Kotak 4 – Tulisan Besar (mis. 6 Hari)'),
            $f('stat4_label', 'Kotak 4 – Keterangan (mis. Senin – Sabtu)'),
        ]),
        'navbar' => $m('Navbar', 'fa-compass', 'Navbar', [$f('navbar_logo', 'Logo Navbar', 'image')]),
    ],
];