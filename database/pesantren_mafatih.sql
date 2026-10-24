SET NAMES utf8mb4;

-- =====================================================
-- Database: pesantren_mafatih
-- Website Pesantren Mafatih Wanayasa (PHP + MySQL)
--
-- CARA IMPORT:
--   1. Buka phpMyAdmin (http://localhost/phpmyadmin)
--   2. Buat database baru / tab "Import"
--   3. Pilih file ini lalu klik Import
-- =====================================================

CREATE DATABASE IF NOT EXISTS pesantren_mafatih
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pesantren_mafatih;

-- ---------- Pengaturan umum situs (key-value) ----------
CREATE TABLE pengaturan (
  kunci VARCHAR(64) PRIMARY KEY,
  nilai TEXT NOT NULL
) ENGINE=InnoDB;

INSERT INTO pengaturan (kunci, nilai) VALUES
('nama_pesantran', 'Pesantren Mafatih Wanayasa'),
('marquee_teks', 'Selamat datang di Website Resmi Pesantren Mafatih Wanayasa'),
('alamat', 'Wanayasa, Purwakarta, Jawa Barat, Indonesia'),
('beranda_label', 'PESANTREN MAFATIH • WANAYASA'),
('beranda_judul', 'Membentuk Generasi Qur''ani & Berkarakter'),
('beranda_teks', 'Pendidikan Islam yang memadukan Al-Qur''an, bahasa Arab, kepemimpinan, dan pembentukan karakter untuk menyiapkan generasi masa depan.'),
('beranda_tentang_1', 'Pesantren Mafatih Wanayasa hadir sebagai ruang pendidikan dan pembinaan generasi yang dekat dengan Al-Qur''an serta memiliki karakter kuat.'),
('beranda_tentang_2', 'Dengan suasana pesantren yang mendukung pembelajaran, santri diarahkan untuk berkembang dalam ilmu, ibadah, komunikasi, kedisiplinan, dan kepemimpinan.'),
('beranda_visi', 'Menjadi lembaga pendidikan Islam yang melahirkan generasi Qur''ani, berilmu, berakhlak, dan mampu memberikan manfaat bagi masyarakat.'),
('beranda_misi', 'Mengembangkan pembelajaran Al-Qur''an, bahasa Arab, karakter, kemandirian, dan kepemimpinan secara terpadu.'),
('admin_user', 'admin'),
('admin_password', '$2y$10$9UYMOcIuu.vK1HVQpBHgu.dBrDcvqTwWfy.6WxR.sCNjXIHRWvx3e'),
('pendaftaran_judul', 'Pendaftaran Santri Baru'),
('pendaftaran_teks', 'Isi formulir berikut untuk mendaftar sebagai santri baru Pesantren Mafatih Wanayasa. Data akan diperiksa oleh pihak administrasi, kemudian kami akan menghubungi wali santri.');

-- ---------- Asatidz & Staff ----------
CREATE TABLE asatidz_staff (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori ENUM('asatidz','staff') NOT NULL DEFAULT 'asatidz',
  nama VARCHAR(100) NOT NULL,
  bidang VARCHAR(150) NOT NULL,
  foto VARCHAR(150) NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO asatidz_staff (kategori, nama, bidang, foto, urutan) VALUES
('asatidz', 'Nama Asatidz', 'Al-Qur''an dan Pendidikan Agama', 'img/asatidz-1.jpg', 1),
('asatidz', 'Nama Asatidz', 'Fiqih dan Keagamaan',            'img/asatidz-2.jpg', 2),
('asatidz', 'Nama Asatidz', 'Bahasa Arab',                    'img/asatidz-3.jpg', 3),
('asatidz', 'Nama Asatidz', 'Hadits dan Akhlak',              'img/asatidz-4.jpg', 4),
('staff',   'Nama Staff',   'Administrasi',                   'img/staff-1.jpg',   1),
('staff',   'Nama Staff',   'Administrasi Pesantren',         'img/staff-2.jpg',   2),
('staff',   'Nama Staff',   'Operasional',                    'img/staff-3.jpg',   3);

-- ---------- Mata Pelajaran ----------
CREATE TABLE mata_pelajaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  deskripsi TEXT NOT NULL,
  ikon VARCHAR(16) NOT NULL DEFAULT '',
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO mata_pelajaran (nama, deskripsi, ikon, is_featured, urutan) VALUES
('Al-Qur''an',        'Pembelajaran membaca, memahami, dan mengamalkan kandungan Al-Qur''an.', '☪', 0, 1),
('Hadits',            'Mempelajari hadits sebagai sumber ajaran dan pedoman dalam kehidupan sehari-hari.', '📖', 1, 2),
('Fiqih',             'Memahami dasar-dasar hukum Islam dan penerapannya dalam kehidupan sehari-hari.', '🕌', 0, 3),
('Akhlak',            'Pembinaan sikap, karakter, dan perilaku yang sesuai dengan nilai-nilai Islam.', '🌙', 0, 4),
('Bahasa Arab',       'Pembelajaran bahasa Arab sebagai bagian dari kemampuan memahami literatur keislaman.', 'ع', 0, 5),
('Bahasa Indonesia',  'Pengembangan kemampuan berbahasa, membaca, menulis, dan berkomunikasi.', 'A', 0, 6),
('Matematika',        'Melatih kemampuan berpikir logis, analitis, dan pemecahan masalah.', '∑', 0, 7),
('Teknologi',         'Mengenalkan pengetahuan dan keterampilan dasar dalam pemanfaatan teknologi.', '💻', 0, 8);

-- ---------- Program ----------
-- tampil_di: 'beranda' = hanya di homepage, 'program' = hanya di halaman Program, 'keduanya'
CREATE TABLE program (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(120) NOT NULL,
  deskripsi TEXT NOT NULL,
  ikon VARCHAR(16) DEFAULT NULL,
  tampil_di ENUM('beranda','program','keduanya') NOT NULL DEFAULT 'program',
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO program (judul, deskripsi, ikon, tampil_di, urutan) VALUES
('Tahfizh Al-Qur''an',      'Program pembinaan hafalan dan interaksi intensif dengan Al-Qur''an.', NULL, 'beranda', 1),
('Bahasa Arab',             'Pembelajaran bahasa Arab untuk mendukung pemahaman literatur dan komunikasi.', NULL, 'beranda', 2),
('Leadership',              'Melatih tanggung jawab, percaya diri, kerja sama, dan kemampuan memimpin.', NULL, 'beranda', 3),
('Pembinaan Karakter',      'Membiasakan disiplin, kemandirian, adab, dan kepedulian dalam kehidupan sehari-hari.', NULL, 'beranda', 4),
('Pendidikan Al-Qur''an',   'Program pembelajaran Al-Qur''an yang meliputi membaca, menghafal, memahami, dan mengamalkan nilai-nilai Al-Qur''an.', '📖', 'program', 1),
('Pendidikan Keagamaan',    'Pembelajaran ilmu agama untuk meningkatkan pemahaman santri terhadap ajaran Islam dan kehidupan sehari-hari.', '🎓', 'program', 2),
('Pembinaan Akhlak',        'Pembentukan karakter santri melalui pembiasaan ibadah, kedisiplinan, tanggung jawab, dan sikap saling menghormati.', '🕌', 'program', 3),
('Pengembangan Keterampilan','Kegiatan yang membantu santri mengembangkan kreativitas, keterampilan teknologi, komunikasi, dan kerja sama.', '💻', 'program', 4),
('Olahraga',                'Kegiatan olahraga sebagai bagian dari pembentukan pola hidup sehat serta meningkatkan kekompakan antar santri.', '⚽', 'program', 5),
('Kegiatan Sosial',         'Santri dilibatkan dalam kegiatan sosial untuk menumbuhkan rasa peduli dan memberikan manfaat bagi masyarakat.', '🌱', 'program', 6);

-- ---------- Berita ----------
CREATE TABLE berita (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori VARCHAR(60) NOT NULL,
  judul VARCHAR(200) NOT NULL,
  deskripsi TEXT NOT NULL,
  konten TEXT NOT NULL,
  gambar VARCHAR(150) DEFAULT NULL,
  tanggal DATE NOT NULL,
  tampil_beranda TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO berita (kategori, judul, deskripsi, konten, tanggal, tampil_beranda) VALUES
('KEGIATAN', 'Kegiatan Pembelajaran Santri',
 'Kegiatan pembelajaran santri dilaksanakan dengan suasana yang aktif dan menyenangkan untuk meningkatkan pemahaman serta kedisiplinan.',
 'Kegiatan pembelajaran santri dilaksanakan dengan suasana yang aktif dan menyenangkan untuk meningkatkan pemahaman serta kedisiplinan. Para santri mengikuti pembelajaran dengan bimbingan para asatidz secara rutin setiap hari.', '2026-09-18', 0),
('PRESTASI', 'Prestasi Santri Pesantren Mafatih',
 'Santri Pesantren Mafatih terus mengembangkan potensi melalui berbagai kegiatan akademik maupun nonakademik.',
 'Santri Pesantren Mafatih terus mengembangkan potensi melalui berbagai kegiatan akademik maupun nonakademik. Prestasi ini menjadi motivasi bagi seluruh santri untuk terus bersemangat dalam belajar.', '2026-09-15', 0),
('KEGIATAN', 'Kegiatan Sosial Bersama Masyarakat',
 'Pesantren Mafatih mengadakan kegiatan sosial sebagai bentuk kepedulian dan kontribusi santri terhadap masyarakat sekitar.',
 'Pesantren Mafatih mengadakan kegiatan sosial sebagai bentuk kepedulian dan kontribusi santri terhadap masyarakat sekitar. Kegiatan ini menjadi sarana melatih kepekaan sosial para santri.', '2026-09-10', 0),
('PENDIDIKAN', 'Program Pendidikan Keagamaan',
 'Program pendidikan keagamaan menjadi salah satu kegiatan utama dalam membentuk karakter dan pemahaman agama para santri.',
 'Program pendidikan keagamaan menjadi salah satu kegiatan utama dalam membentuk karakter dan pemahaman agama para santri. Program ini berjalan beriringan dengan kegiatan pembinaan harian di pesantren.', '2026-09-05', 0),
('KEGIATAN PESANTREN', 'Pembinaan Santri dan Kegiatan Keislaman',
 'Beragam kegiatan pembinaan menjadi bagian dari kehidupan santri di Mafatih.',
 'Beragam kegiatan pembinaan menjadi bagian dari kehidupan santri di Mafatih, mulai dari ibadah harian, tahfizh, hingga pembinaan adab dan kedisiplinan.', '2026-09-01', 1),
('TAHFIZH', 'Menumbuhkan Semangat Bersama Al-Qur''an',
 'Budaya menghafal dan memahami Al-Qur''an dibangun melalui pembiasaan yang konsisten.',
 'Budaya menghafal dan memahami Al-Qur''an dibangun melalui pembiasaan yang konsisten, seperti murajaah dan setoran hafalan bersama pembina.', '2026-08-25', 1),
('PENGEMBANGAN DIRI', 'Belajar Memimpin, Belajar Bertanggung Jawab',
 'Santri mendapatkan ruang untuk belajar berorganisasi dan mengembangkan kepemimpinan.',
 'Santri mendapatkan ruang untuk belajar berorganisasi dan mengembangkan kepemimpinan melalui piket, panitia kegiatan, dan latihan kepemimpinan rutin.', '2026-08-20', 1);

-- ---------- Galeri ----------
CREATE TABLE galeri (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kategori VARCHAR(60) NOT NULL,
  judul VARCHAR(150) NOT NULL,
  gambar VARCHAR(150) DEFAULT NULL,
  ukuran ENUM('normal','besar') NOT NULL DEFAULT 'normal',
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO galeri (kategori, judul, ukuran, urutan) VALUES
('Kegiatan',   'Pembelajaran Santri',           'besar',  1),
('Keagamaan',  'Kegiatan Ibadah',               'normal', 2),
('Pendidikan', 'Belajar Bersama',               'normal', 3),
('Kegiatan',   'Aktivitas Santri',              'normal', 4),
('Sosial',     'Kegiatan Bersama Masyarakat',   'besar',  5),
('Olahraga',   'Aktivitas Olahraga',            'normal', 6);

-- ---------- Visi & Misi ----------
CREATE TABLE visi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pernyataan TEXT NOT NULL,
  deskripsi TEXT NOT NULL
) ENGINE=InnoDB;

INSERT INTO visi (pernyataan, deskripsi) VALUES
('Membangun generasi yang berilmu, berakhlak, mandiri, dan memiliki nilai-nilai keislaman.',
 'Visi ini menjadi arah dalam menciptakan lingkungan pendidikan yang tidak hanya berfokus pada pengetahuan, tetapi juga pembentukan karakter dan akhlak santri.');

CREATE TABLE misi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(120) NOT NULL,
  isi TEXT NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO misi (judul, isi, urutan) VALUES
('Pendidikan Keislaman',  'Menyelenggarakan pendidikan keagamaan yang membantu santri memahami dan mengamalkan ajaran Islam.', 1),
('Pembentukan Akhlak',    'Membentuk karakter santri agar memiliki sikap santun, bertanggung jawab, dan menghargai sesama.', 2),
('Pengembangan Potensi',  'Memberikan ruang bagi santri untuk mengembangkan kemampuan akademik maupun nonakademik.', 3),
('Kemandirian Santri',    'Menumbuhkan kedisiplinan dan kemandirian melalui kegiatan pendidikan dan kehidupan pesantren.', 4);

-- ---------- Sejarah Pesantren ----------
CREATE TABLE sejarah (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(120) NOT NULL,
  isi TEXT NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO sejarah (judul, isi, urutan) VALUES
('Awal Berdiri',              'Pesantren Mafatih hadir sebagai tempat pendidikan dan pembinaan keagamaan bagi masyarakat sekitar Wanayasa.', 1),
('Perkembangan Pendidikan',   'Seiring perkembangan kebutuhan pendidikan, kegiatan pembelajaran dan pembinaan santri terus dikembangkan.', 2),
('Pesantren Saat Ini',        'Pesantren terus berupaya memberikan pendidikan yang relevan dengan tetap mempertahankan nilai-nilai keislaman.', 3);

-- ---------- Nilai Pesantren ----------
CREATE TABLE nilai (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(120) NOT NULL,
  isi TEXT NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO nilai (judul, isi, urutan) VALUES
('Keislaman',     'Menanamkan pemahaman dan pengamalan nilai-nilai Islam.', 1),
('Akhlak',        'Membentuk pribadi yang memiliki sikap santun dan bertanggung jawab.', 2),
('Kedisiplinan',  'Membangun kebiasaan disiplin dalam kegiatan sehari-hari.', 3),
('Kemandirian',   'Mendorong santri agar mampu berkembang dan bertanggung jawab.', 4);

-- ---------- Info Kontak (kartu pada halaman Kontak) ----------
CREATE TABLE kontak_info (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ikon VARCHAR(16) NOT NULL,
  label VARCHAR(60) NOT NULL,
  judul VARCHAR(120) NOT NULL,
  isi TEXT NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO kontak_info (ikon, label, judul, isi, urutan) VALUES
('⌂', 'ALAMAT',        'Pesantren Mafatih',        'Wanayasa, Purwakarta,\nJawa Barat, Indonesia.', 1),
('☎', 'TELEPON',       'Hubungi Pesantren',        'Informasi nomor telepon dapat diperoleh melalui pihak administrasi pesantren.', 2),
('✉', 'EMAIL',         'Email Pesantren',          'Gunakan email resmi pesantren untuk pertanyaan dan informasi.', 3),
('◎', 'MEDIA SOSIAL',  'Instagram & YouTube',      'Ikuti media sosial Mafatih untuk melihat informasi dan kegiatan terbaru.', 4);

-- ---------- Pesan dari formulir kontak ----------
CREATE TABLE pesan_kontak (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subjek VARCHAR(150) NOT NULL,
  pesan TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------- Testimoni wali santri / alumni ----------
CREATE TABLE testimoni (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  asal VARCHAR(120) NOT NULL,
  isi TEXT NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO testimoni (nama, asal, isi, urutan) VALUES
('Wali Santri', 'Orang tua santri angkatan 2025', 'Pembinaan di Pesantren Mafatih terasa dekat dan personal. Anak saya menjadi lebih disiplin dan nyaman menghafal Al-Qur''an.', 1),
('Alumni', 'Pengasuh rumah tahfizh, Purwakarta', 'Bekal bahasa Arab dan karakter yang saya dapatkan di Mafatih sangat membantu saat melanjutkan studi dan mengajar.', 2),
('Wali Santri', 'Orang tua santri angkatan 2024', 'Komunikasi pihak pesantren dengan wali santri baik, perkembangan hafalan dan akhlak anak selalu terpantau.', 3);

-- ---------- FAQ / pertanyaan umum ----------
CREATE TABLE faq (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pertanyaan TEXT NOT NULL,
  jawaban TEXT NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO faq (pertanyaan, jawaban, urutan) VALUES
('Apa saja syarat pendaftaran santri baru?', 'Calon santri mengisi formulir pendaftaran online atau langsung, mel fotocopy KTP/KK, rapor terakhir, dan siap mengikuti tahap survey/psikotes sederhana bersama wali santri.', 1),
('Berapa biaya pendidikan di Pesantren Mafatih?', 'Biaya terdiri dari SPP bulanan dan sarana prasarana yang mencakup tempat tinggal, makan, dan pembelajaran. Rincian terbaru dapat ditanyakan melalui halaman Kontak atau WhatsApp administrasi.', 2),
('Santri jenjang apa yang diterima?', 'Santri yang sedang menempuh atau baru lulus SD/MI hingga SMP/MTs dan sederajat, dengan usia minimal yang ditentukan oleh pengurus.', 3),
('Apakah santri boleh dikunjungi wali?', 'Boleh, mengikuti jadwal kunjungan (ziyarah) yang ditetapkan pengurus agar pembelajaran dan pembinaan tetap kondusif.', 4),
('Bagaimana jika santri belum bisa membaca Al-Qur''an?', 'Tidak masalah. Santri akan dibimbing dari dasar melalui program tahsin dan pembinaan harian hingga mampu membaca dengan baik.', 5);

-- ---------- Pendaftaran santri baru (PPDB) ----------
CREATE TABLE pendaftaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_santri VARCHAR(100) NOT NULL,
  tempat_lahir VARCHAR(80) NOT NULL,
  tanggal_lahir DATE NOT NULL,
  jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
  asal_sekolah VARCHAR(120) NOT NULL,
  nama_wali VARCHAR(100) NOT NULL,
  telepon_wali VARCHAR(30) NOT NULL,
  alamat TEXT NOT NULL,
  program_diminati VARCHAR(80) NOT NULL DEFAULT '',
  status ENUM('baru','diproses','diterima','ditolak') NOT NULL DEFAULT 'baru',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------- Kalender akademik ----------
CREATE TABLE kalender_akademik (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  kategori VARCHAR(60) NOT NULL DEFAULT 'Kegiatan',
  deskripsi TEXT NOT NULL,
  tanggal_mulai DATE NOT NULL,
  tanggal_selesai DATE DEFAULT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO kalender_akademik (judul, kategori, deskripsi, tanggal_mulai, tanggal_selesai, urutan) VALUES
('Awal Masuk & Ta''aruf Santri Baru', 'Pembelajaran', 'Kedatangan santri baru, orientasi lingkungan pesantren, dan ta''aruf bersama asatidz.', '2026-07-13', '2026-07-17', 1),
('Awal Semester Ganjil 1448 H / 2026-2027', 'Pembelajaran', 'Pembukaan kegiatan belajar mengajar semester ganjil untuk seluruh tingkatan.', '2026-07-20', NULL, 2),
('Libur Awal Maulid Nabi 1448 H', 'Libur', 'Libur perayaan Maulid Nabi Muhammad SAW.', '2026-08-25', '2026-08-27', 4),
('Peringatan Maulid Nabi & Kajian Akbar', 'Kegiatan', 'Kajian akbar, munaqasyah, dan penampilan santri.', '2026-08-28', NULL, 5),
('Ujian Tengah Semester Ganjil', 'Ujian', 'UTS semester ganjil meliputi tahfizh, bahasa Arab, dan pelajaran formal.', '2026-10-19', '2026-10-24', 3),
('Wisuda Tahfizh & Halal Bi Halil', 'Kegiatan', 'Wisuda hafizh/hafizhah dan halal bi halil wali santri.', '2026-12-05', NULL, 6),
('Ujian Akhir Semester Ganjil', 'Ujian', 'PAS semester ganjil, termasuk ujian hafalan (tasmi''an).', '2026-12-14', '2026-12-19', 7),
('Libur Semester Ganjil', 'Libur', 'Libur akhir semester ganjil dan kepulangan santri ke rumah masing-masing.', '2026-12-21', '2027-01-02', 8),
('Awal Semester Genap', 'Pembelajaran', 'Masuk kembali dan dimulainya KBM semester genap.', '2027-01-04', NULL, 9);

-- ---------- Data santri ----------
CREATE TABLE santri (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  tingkat VARCHAR(40) NOT NULL DEFAULT 'SMP',
  angkatan VARCHAR(20) NOT NULL DEFAULT '',
  status ENUM('aktif','pulang','lulus','keluar') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB;

INSERT INTO santri (nama, tingkat, angkatan, status) VALUES
('Ahmad Fauzan','SMP','2025','aktif'),('Siti Nurhaliza','SMP','2025','aktif'),('Muhammad Rizki','SMA','2024','aktif'),
('Annisa Rahma','SMP','2026','aktif'),('Abdullah Hakim','SMP','2025','aktif'),('Fatimah Azzahra','SMA','2024','aktif'),
('Yusuf Abdillah','SMP','2026','aktif'),('Khadijah Ulya','SMP','2025','aktif'),('Ibrahim Khalid','SMA','2023','lulus'),
('Maryam Salsabila','SMP','2025','aktif'),('Hasan Basri','SMP','2026','aktif'),('Husain Ali','SMP','2024','pulang'),
('Zainab Afiifah','SMA','2025','aktif'),('Umar Faruq','SMP','2025','aktif'),('Ali Zakiy','SMP','2026','aktif'),
('Aisyah Nayla','SMP','2025','aktif'),('Bilal Ramadhan','SMA','2024','aktif'),('Shofiyah binti Huyay','SMP','2023','lulus'),
('Thalhah Ubaid','SMP','2025','aktif'),('Sa''ad bin Abi Waqqash','SMA','2024','aktif');

-- ---------- Prestasi santri ----------
CREATE TABLE prestasi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  peraih VARCHAR(120) NOT NULL,
  tingkat VARCHAR(60) NOT NULL DEFAULT 'Kabupaten',
  deskripsi TEXT NOT NULL,
  tanggal DATE NOT NULL,
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO prestasi (judul, peraih, tingkat, deskripsi, tanggal, urutan) VALUES
('Juara 1 MHQ 5 Juz Tingkat Kabupaten','Ahmad Fauzan (santri)','Kabupaten','Musabaqah Hifdzil Qur''an 5 juz pada ajang PHPT tingkat kabupaten Purwakarta.','2026-08-15',1),
('Juara 2 Kaligrafi Tingkat Provinsi','Siti Nurhaliza (santri)','Provinsi','Lomba kaligrafi Islam tingkat Jawa Barat.','2026-06-20',2),
('Santri Teladan Tingkat Nasional','Umar Faruq (santri)','Nasional','Penghargaan santri teladan pada Jambore Pesantren Nusantara.','2026-04-10',3),
('Juara 1 Pidato Bahasa Arab Tingkat Kabupaten','Khadijah Ulya (santri)','Kabupaten','Muhadharah bahasa Arab antar pesantren se-Kabupaten Purwakarta.','2025-11-08',4);

-- ---------- Berkas unduhan ----------
CREATE TABLE berkas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(150) NOT NULL,
  kategori VARCHAR(60) NOT NULL DEFAULT 'Formulir',
  deskripsi TEXT NOT NULL,
  url VARCHAR(255) NOT NULL DEFAULT '#',
  ukuran VARCHAR(30) NOT NULL DEFAULT '',
  urutan INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO berkas (nama, kategori, deskripsi, url, ukuran, urutan) VALUES
('Formulir Pendaftaran Santri Baru','Formulir','Formulir PPDB cetak untuk pendaftaran langsung di kantor pesantren.','uploads/formulir-ppdb.pdf','250 KB',1),
('Panduan Santri Baru 1448 H','Panduan','Buku sapa berisi tata tertib, aktivitas harian, dan perlengkapan santri.','uploads/panduan-santri.pdf','1,2 MB',2),
('Contoh Surat Keterangan Wali','Surat','Template surat keterangan pekerjaan wali santri untuk administrasi.','uploads/contoh-surat.pdf','180 KB',3);

-- ---------- Penghitung kunjungan ----------
CREATE TABLE kunjungan (
  id INT PRIMARY KEY,
  jumlah INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO kunjungan (id, jumlah) VALUES (1, 0);

-- ---------- Tambahan pengaturan kontak ----------
INSERT INTO pengaturan (kunci, nilai) VALUES
('wa_number', '6281234567890'),
('email', 'info@pesantrenmafatih.sch.id');
