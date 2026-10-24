<?php
require __DIR__ . '/config/database.php';

$active = 'berita-detail';
$page_title = 'Berita - Pesantren Mafatih Wanayasa';
$page_css = 'Berita.css';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$b = null;
if ($id !== false && $id !== null) {
    $st = db()->prepare('SELECT id, kategori, judul, deskripsi, konten, gambar, tanggal FROM berita WHERE id = ?');
    $st->execute([$id]);
    $b = $st->fetch();
}
if (!$b) {
    $page_title = 'Berita tidak ditemukan';
    require __DIR__ . '/includes/header.php';
    echo '<main><section class="content" style="padding-top:64px;"><article class="news-card solo"><div class="news-content">'
        . '<h3>Berita tidak ditemukan</h3><p>Artikel yang Anda cari tidak ada atau sudah dihapus.</p>'
        . '<a href="berita.php">&larr; Kembali ke Berita</a></div></article></section></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
$page_title = $b['judul'] . ' - Pesantren Mafatih Wanayasa';

$st = db()->prepare('SELECT id, kategori, judul, tanggal FROM berita
    WHERE id <> ? ORDER BY (kategori = ?) DESC, tanggal DESC LIMIT 3');
$st->execute([$id, $b['kategori']]);
$related = $st->fetchAll();

require __DIR__ . '/includes/header.php';
?>
    <main>
        <section class="content article-wrap">
            <nav class="breadcrumb">
                <a href="index.php">Beranda</a> ›
                <a href="berita.php">Berita</a> ›
                <span><?= e($b['kategori']) ?></span>
            </nav>
            <article class="news-card solo">
                <?php if ($b['gambar']): ?>
                <div class="article-hero" style="background-image:url('<?= e($b['gambar']) ?>')"></div>
                <?php endif; ?>
                <div class="news-content">
                    <small><?= e($b['kategori']) ?> &bull; <?= e(tgl_id($b['tanggal'])) ?></small>
                    <h1><?= e($b['judul']) ?></h1>
                    <p><?= nl2br(e($b['konten'])) ?></p>
                    <div class="article-share">
                        <a class="small-btn" target="_blank" rel="noopener"
                           href="https://wa.me/?text=<?= rawurlencode($b['judul'] . ' — ' . pengaturan('nama_pesantran')) ?>">
                            <i class="fa-brands fa-whatsapp"></i> Bagikan ke WhatsApp
                        </a>
                        <a href="berita.php">&larr; Kembali ke Berita</a>
                    </div>
                </div>
            </article>
            <?php if ($related): ?>
            <section class="related">
                <div class="section-title">
                    <span>BACA JUGA</span>
                    <h2>Berita Lainnya</h2>
                </div>
                <div class="related-grid">
                    <?php foreach ($related as $r): ?>
                    <a class="related-card reveal" href="berita_detail.php?id=<?= (int) $r['id'] ?>">
                        <small><?= e($r['kategori']) ?> &bull; <?= e(tgl_id($r['tanggal'])) ?></small>
                        <h3><?= e($r['judul']) ?></h3>
                    </a>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
