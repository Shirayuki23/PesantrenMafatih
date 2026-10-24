<?php
$active = 'sitemap';
$page_title = 'Peta Situs - Pesantren Mafatih Wanayasa';
$page_css = 'Sitemap.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Peta Situs']];

// Struktur informasi lengkap situs, selaras dengan menu utama.
$sitemap = [
    ['Tentang', [
        ['profil.php', 'Tentang Pesantren', 'Profil, sejarah, dan lingkungan pesantren'],
        ['visi-misi.php', 'Visi & Misi', 'Arah dan langkah lembaga'],
        ['asatidz.php', 'Data Asatidz & Staff', 'Pengajar dan tenaga kependidikan'],
        ['prestasi.php', 'Prestasi Santri', 'Torehan kompetisi akademik & keagamaan'],
    ]],
    ['Akademik', [
        ['program.php', 'Program', 'Program unggulan dan kegiatan belajar'],
        ['mapel.php', 'Mata Pelajaran', 'Kajian yang dipelajari santri'],
        ['kalender.php', 'Kalender Akademik', 'Jadwal semester, ujian, libur, dan agenda'],
        ['download.php', 'Download Berkas', 'Formulir, panduan, dan dokumen resmi'],
    ]],
    ['Informasi', [
        ['berita.php', 'Berita & Kegiatan', 'Kabar terbaru seputar pesantren'],
        ['galeri.php', 'Galeri', 'Dokumentasi kegiatan santri'],
        ['faq.php', 'FAQ', 'Pertanyaan yang sering diajukan'],
        ['kontak.php', 'Kontak', 'Alamat, kanal resmi, dan formulir pesan'],
    ]],
    ['Pendaftaran', [
        ['pendaftaran.php', 'Formulir PPDB', 'Pendaftaran santri baru online'],
        ['cari.php', 'Pencarian', 'Cari berita, program, kalender, dan lainnya'],
    ]],
];
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>PETA SITUS</span>
                <h1>Struktur Informasi Situs</h1>
                <p>Seluruh halaman resmi <?= e(pengaturan('nama_pesantran')) ?> dalam satu pandangan.</p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content smap-wrap">
            <div class="smap-grid">
                <?php foreach ($sitemap as $i => [$group, $items]): ?>
                <div class="smap-card reveal">
                    <span class="smap-num"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <h2><?= e($group) ?></h2>
                    <ul>
                        <?php foreach ($items as [$href, $label, $desc]): ?>
                        <li>
                            <a href="<?= e($href) ?>"><?= e($label) ?></a>
                            <small><?= e($desc) ?></small>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
                <div class="smap-card smap-home">
                    <h2>Halaman Utama</h2>
                    <ul>
                        <li><a href="index.php">Beranda</a><small>Ringkasan profil, statistik, program, berita, testimoni</small></li>
                    </ul>
                </div>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
