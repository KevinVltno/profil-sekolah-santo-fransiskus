-- Data awal SD Santo Fransiskus Sragen.
-- Bagian yang butuh foto (guru, galeri, berita, fasilitas, program, ekskul, prestasi, testimoni)
-- sengaja dikosongkan; isi lewat dashboard admin.
INSERT INTO konten (seksi,gambar,ikon,judul,teks,teks2,bintang,tanggal,tahun,urutan) VALUES
('beranda_tumbuh','img/logo.png','','','','',0,NULL,'',1),
('beranda_sejarah','','','Lebih dari Lima Dekade Mendampingi Anak-Anak Sragen','SD Santo Fransiskus Sragen adalah sekolah dasar Katolik yang berdiri sejak tahun 1968 di bawah naungan Yayasan Mardi Lestari Sragen. Sejak awal, kami berkomitmen menghadirkan tempat belajar yang menyenangkan, aman, dan penuh kasih bagi anak-anak. Kini sekolah kami terakreditasi A dan menjalankan Kurikulum Merdeka.','',0,NULL,'',1),
('profil_sejarah','','','Mendampingi Anak Belajar dan Bertumbuh dengan Penuh Kasih','SD Santo Fransiskus Sragen adalah sekolah dasar Katolik yang berdiri sejak tahun 1968 di bawah naungan Yayasan Mardi Lestari Sragen dan telah terakreditasi A. Kami menghadirkan suasana belajar yang menyenangkan, aman, dan penuh kasih, dengan pembelajaran yang mengacu pada Kurikulum Merdeka.','',0,NULL,'',1),
('beranda_keunggulan','','fa-trophy','Terakreditasi A','Terakreditasi A oleh BAN-S/M sebagai bukti mutu layanan pendidikan kami.','',0,NULL,'',1),
('beranda_keunggulan','','fa-chalkboard-user','Guru Berdedikasi','Tenaga pendidik yang sabar dan penuh perhatian dalam mendampingi setiap siswa.','',0,NULL,'',2),
('beranda_keunggulan','','fa-puzzle-piece','Kurikulum Merdeka','Pembelajaran berpusat pada kebutuhan dan potensi setiap siswa.','',0,NULL,'',3),
('beranda_keunggulan','','fa-seedling','Karakter dan Iman','Menanamkan iman, sopan santun, kejujuran, dan tanggung jawab dalam keseharian siswa.','',0,NULL,'',4),
('beranda_keunggulan','','fa-palette','Kegiatan Beragam','Kegiatan akademik dan non-akademik untuk mengembangkan bakat dan minat siswa.','',0,NULL,'',5),
('beranda_keunggulan','','fa-shield-halved','Lingkungan Aman','Suasana sekolah yang aman, nyaman, dan penuh kasih sayang bagi setiap siswa.','',0,NULL,'',6),
('profil_keunggulan','','fa-trophy','Terakreditasi A','Terakreditasi A oleh BAN-S/M sebagai bukti mutu layanan pendidikan kami.','',0,NULL,'',1),
('profil_keunggulan','','fa-chalkboard-user','Guru Berdedikasi','Tenaga pendidik yang sabar dan penuh perhatian dalam mendampingi setiap siswa.','',0,NULL,'',2),
('profil_keunggulan','','fa-puzzle-piece','Kurikulum Merdeka','Pembelajaran berpusat pada kebutuhan dan potensi setiap siswa.','',0,NULL,'',3),
('profil_keunggulan','','fa-seedling','Karakter dan Iman','Menanamkan iman, sopan santun, kejujuran, dan tanggung jawab dalam keseharian siswa.','',0,NULL,'',4),
('profil_keunggulan','','fa-palette','Kegiatan Beragam','Kegiatan akademik dan non-akademik untuk mengembangkan bakat dan minat siswa.','',0,NULL,'',5),
('profil_keunggulan','','fa-calendar-days','Pengalaman Sejak 1968','Lebih dari lima dekade mendampingi anak-anak Sragen belajar dan bertumbuh.','',0,NULL,'',6),
('profil_visimisi','','','Visi','Membentuk insan yang beriman kepada Tuhan, berakhlak mulia, dan cerdas, berlandaskan nilai moral serta persaudaraan yang dijiwai cinta kasih.','',0,NULL,'',1),
('profil_visimisi','','','Misi','Menumbuhkan keimanan dan nilai moral secara konsisten dalam kehidupan sekolah.
Membangun komunitas sekolah yang bersaudara, disiplin, dan matang secara emosional melalui pendampingan pribadi dan layanan bimbingan bagi siswa.
Meningkatkan kualitas guru dan siswa dalam menjalankan tugasnya sesuai tuntutan zaman.
Memperkuat kerja sama dengan pihak internal maupun eksternal sekolah.','',0,NULL,'',2),
('beranda_faq','','','Jenjang apa saja yang tersedia?','SD Santo Fransiskus menyelenggarakan pendidikan dasar dari kelas 1 sampai kelas 6.','',0,NULL,'',1),
('beranda_faq','','','Bagaimana cara mendaftar?','Hubungi sekolah melalui telepon 0271-890911 atau datang langsung ke sekolah. Kami akan menjelaskan persyaratan dan jadwal pendaftaran.','',0,NULL,'',2),
('beranda_faq','','','Kapan jam belajar di sekolah?','Kegiatan belajar berlangsung pagi hari, Senin sampai Sabtu. Untuk jam yang pasti, silakan hubungi sekolah.','',0,NULL,'',3),
('beranda_faq','','','Berapa biaya pendaftaran dan uang sekolah?','Untuk informasi biaya terbaru, silakan hubungi sekolah agar mendapat penjelasan yang akurat.','',0,NULL,'',4),
('beranda_faq','','','Apakah sekolah sudah terakreditasi?','Ya, SD Santo Fransiskus Sragen terakreditasi A oleh BAN-S/M.','',0,NULL,'',5),
('beranda_faq','','','Di mana lokasi sekolah?','Jalan Rokan No. 15, Sragen Tengah, Kecamatan Sragen, Kabupaten Sragen, Jawa Tengah 57211. Peta lengkap ada di halaman Hubungi Kami.','',0,NULL,'',6);

INSERT INTO pengaturan (kunci,nilai) VALUES
('kontak_alamat','Jalan Rokan No. 15, Sragen Tengah, Kecamatan Sragen, Kabupaten Sragen, Jawa Tengah 57211'),
('kontak_telepon','0271-890911'),
('kontak_email','operator.sdsantofransiskus@gmail.com'),
('kontak_jam','Senin – Sabtu'),
('navbar_logo','img/logo.png'),
('footer_logo','img/logo.png'),
('footer_deskripsi','SD Santo Fransiskus Sragen mendampingi anak belajar dan bertumbuh dengan penuh kasih sejak 1968.'),
('hero_badge','Penerimaan Siswa Baru'),
('hero_judul1','Tumbuh & Berkembang'),
('hero_judul2','Bersama Santo Fransiskus'),
('hero_deskripsi','Sekolah dasar Katolik di Sragen yang mendampingi anak belajar dalam lingkungan yang menyenangkan, aman, dan penuh kasih sayang.'),
('hero_tombol1','Daftar via WhatsApp'),
('hero_tombol2','Kenali Kami'),
('stat1_angka','1968'),
('stat1_label','Tahun Berdiri'),
('stat2_angka','A'),
('stat2_label','Akreditasi BAN-S/M'),
('stat3_angka','1–6'),
('stat3_label','Jenjang Kelas'),
('stat4_angka','6 Hari'),
('stat4_label','Senin – Sabtu');
