<?php
$active = 'download';
$page_title = 'Download Berkas - Pesantren Mafatih Wanayasa';
$page_css = 'Download.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Download Berkas']];

$berkas = db()->query('SELECT id, nama, kategori, deskripsi, url, ukuran FROM berkas ORDER BY kategori, urutan')->fetchAll();
$kats = array_values(array_unique(array_column($berkas, 'kategori')));
$iconKat = ['Formulir' => 'fa-file-lines', 'Panduan' => 'fa-book-open', 'Surat' => 'fa-envelope-open-text'];
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>BERKAS RESMI</span>
                <h1>Download Berkas</h1>
                <p>Unduh formulir, panduan, dan dokumen resmi <?= e(pengaturan('nama_pesantran')) ?>.</p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content dl-wrap">
            <?php if (count($kats) > 1): ?>
            <div class="chip-row" data-filter-group=".dl-item">
                <button class="chip active" data-cat="">Semua</button>
                <?php foreach ($kats as $k): ?>
                <button class="chip" data-cat="<?= e($k) ?>"><?= e($k) ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="dl-grid">
                <?php foreach ($berkas as $b): ?>
                <article class="dl-item reveal" data-cat="<?= e($b['kategori']) ?>">
                    <div class="dl-ico"><i class="fa-solid <?= e($iconKat[$b['kategori']] ?? 'fa-file') ?>"></i></div>
                    <div class="dl-body">
                        <small><?= e($b['kategori']) ?><?= $b['ukuran'] ? ' &bull; ' . e($b['ukuran']) : '' ?></small>
                        <h3><?= e($b['nama']) ?></h3>
                        <p><?= e($b['deskripsi']) ?></p>
                        <a class="small-btn dl-btn" href="<?= e($b['url'] ?: '#') ?>"<?= $b['url'] !== '#' ? ' download' : '' ?>>
                            <i class="fa-solid fa-download"></i> Unduh
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php if (!$berkas): ?><p class="muted">Belum ada berkas yang tersedia.</p><?php endif; ?>
            </div>
            <p class="dl-note muted">Berkas bersifat contoh. Untuk dokumen terbaru, hubungi administrasi melalui <a href="kontak.php">halaman Kontak</a>.</p>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
