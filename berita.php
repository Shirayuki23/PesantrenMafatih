<?php
$active = 'berita';
$page_title = 'Berita - Pesantren Mafatih Wanayasa';
$page_css = 'Berita.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Berita']];

$kats = db()->query('SELECT DISTINCT kategori FROM berita ORDER BY kategori')->fetchAll(PDO::FETCH_COLUMN);
$kat = trim((string) ($_GET['kategori'] ?? ''));
if ($kat !== '' && !in_array($kat, $kats, true)) {
    $kat = '';
}
$page = max(1, (int) ($_GET['page'] ?? 1));
$per = 6;

if ($kat === '') {
    $total = (int) db()->query('SELECT COUNT(*) FROM berita')->fetchColumn();
    $berita = db()->query("SELECT id, kategori, judul, deskripsi, gambar, tanggal FROM berita
        ORDER BY tanggal DESC LIMIT $per OFFSET " . (($page - 1) * $per))->fetchAll();
} else {
    $st = db()->prepare('SELECT COUNT(*) FROM berita WHERE kategori = ?');
    $st->execute([$kat]);
    $total = (int) $st->fetchColumn();
    $st = db()->prepare('SELECT id, kategori, judul, deskripsi, gambar, tanggal FROM berita
        WHERE kategori = ? ORDER BY tanggal DESC LIMIT ' . $per . ' OFFSET ' . (int) (($page - 1) * $per));
    $st->execute([$kat]);
    $berita = $st->fetchAll();
}
$pages = max(1, (int) ceil($total / $per));
$imgClasses = ['image-one', 'image-two', 'image-three', 'image-four'];
$q = function (int $p) use ($kat) {
    return 'berita.php?page=' . $p . ($kat !== '' ? '&kategori=' . urlencode($kat) : '');
};
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>INFORMASI TERKINI</span>
                <h1>Berita Pesantren</h1>
                <p>
                    Informasi terbaru mengenai kegiatan, prestasi, dan berbagai
                    aktivitas <?= e(pengaturan('nama_pesantran')) ?>.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content">
            <div class="section-title">
                <span>BERITA TERBARU</span>
                <h2>Kabar dari Pesantren Mafatih</h2>
            </div>
            <div class="chip-row" role="list">
                <a class="chip<?= $kat === '' ? ' active' : '' ?>" href="berita.php">Semua</a>
                <?php foreach ($kats as $k): ?>
                <a class="chip<?= $k === $kat ? ' active' : '' ?>" href="berita.php?kategori=<?= urlencode($k) ?>"><?= e($k) ?></a>
                <?php endforeach; ?>
            </div>
            <div class="news-container">
                <?php foreach ($berita as $i => $b): ?>
                <article class="news-card reveal">
                    <div class="news-image <?= $imgClasses[$i % 4] ?>"<?= $b['gambar'] ? ' style="background-image:url(\'' . e($b['gambar']) . '\')"' : '' ?>>
                        <span><?= e($b['kategori']) ?></span>
                    </div>
                    <div class="news-content">
                        <small><?= e(tgl_id($b['tanggal'])) ?></small>
                        <h3><?= e($b['judul']) ?></h3>
                        <p><?= e($b['deskripsi']) ?></p>
                        <a href="berita_detail.php?id=<?= (int) $b['id'] ?>">Baca Selengkapnya →</a>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php if (!$berita): ?>
                <p class="muted">Belum ada berita pada kategori ini.</p>
                <?php endif; ?>
            </div>
            <?php if ($pages > 1): ?>
            <nav class="pager">
                <?php if ($page > 1): ?><a href="<?= e($q($page - 1)) ?>">← Sebelumnya</a><?php endif; ?>
                <?php for ($p = 1; $p <= $pages; $p++): ?>
                    <?php if ($p === $page): ?><span class="current"><?= $p ?></span>
                    <?php else: ?><a href="<?= e($q($p)) ?>"><?= $p ?></a><?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $pages): ?><a href="<?= e($q($page + 1)) ?>">Berikutnya →</a><?php endif; ?>
            </nav>
            <?php endif; ?>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
