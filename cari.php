<?php
require __DIR__ . '/config/database.php';

$active = 'cari';
$page_title = 'Pencarian - Pesantren Mafatih Wanayasa';
$page_css = 'Cari.css';

$q = trim((string) ($_GET['q'] ?? ''));
$like = '';
$results = ['berita' => [], 'program' => [], 'mapel' => [], 'asatidz' => [], 'galeri' => [], 'kalender' => []];
if (mb_strlen($q) >= 2) {
    $esc = str_replace(['%', '_'], ['\%', '\_'], $q);
    $like = '%' . $esc . '%';
    $st = db()->prepare('SELECT id, kategori, judul, tanggal FROM berita WHERE judul LIKE ? OR deskripsi LIKE ? ORDER BY tanggal DESC LIMIT 10');
    $st->execute([$like, $like]);
    $results['berita'] = $st->fetchAll();
    $st = db()->prepare('SELECT judul, deskripsi FROM program WHERE judul LIKE ? OR deskripsi LIKE ? ORDER BY urutan LIMIT 10');
    $st->execute([$like, $like]);
    $results['program'] = $st->fetchAll();
    $st = db()->prepare('SELECT nama, deskripsi FROM mata_pelajaran WHERE nama LIKE ? OR deskripsi LIKE ? ORDER BY urutan LIMIT 10');
    $st->execute([$like, $like]);
    $results['mapel'] = $st->fetchAll();
    $st = db()->prepare("SELECT kategori, nama, bidang FROM asatidz_staff WHERE nama LIKE ? OR bidang LIKE ? ORDER BY kategori, urutan LIMIT 10");
    $st->execute([$like, $like]);
    $results['asatidz'] = $st->fetchAll();
    $st = db()->prepare('SELECT kategori, judul FROM galeri WHERE judul LIKE ? OR kategori LIKE ? ORDER BY urutan LIMIT 10');
    $st->execute([$like, $like]);
    $results['galeri'] = $st->fetchAll();
    $st = db()->prepare('SELECT id, kategori, judul, tanggal_mulai, tanggal_selesai FROM kalender_akademik WHERE judul LIKE ? OR deskripsi LIKE ? OR kategori LIKE ? ORDER BY tanggal_mulai LIMIT 10');
    $st->execute([$like, $like, $like]);
    $results['kalender'] = $st->fetchAll();
}
$total = array_sum(array_map('count', $results));
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Hasil Pencarian']];
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>PENCARIAN</span>
                <h1>Hasil Pencarian</h1>
                <?php if ($q !== ''): ?>
                <p><?= $total ?> hasil ditemukan untuk kata kunci "<b><?= e($q) ?></b>".</p>
                <?php else: ?>
                <p>Ketik minimal 2 huruf untuk mencari berita, program, mata pelajaran, asatidz, kalender, dan galeri.</p>
                <?php endif; ?>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content cari-wrap">
            <form class="search-inline" action="cari.php" method="get">
                <input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari..." required minlength="2">
                <button type="submit" class="btn primary">Cari</button>
            </form>

            <?php if ($q !== '' && $total === 0): ?>
            <p class="muted empty-hint">Tidak ada hasil. Periksa ejaan atau coba kata kunci lain, misalnya <a href="cari.php?q=tahfizh">tahfizh</a>.</p>
            <?php endif; ?>

            <?php if ($results['berita']): ?>
            <div class="result-group">
                <h2>Berita <span>(<?= count($results['berita']) ?>)</span></h2>
                <?php foreach ($results['berita'] as $r): ?>
                <a class="result-item" href="berita_detail.php?id=<?= (int) $r['id'] ?>">
                    <small><?= e($r['kategori']) ?> &bull; <?= e(tgl_id($r['tanggal'])) ?></small>
                    <h3><?= e($r['judul']) ?></h3>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($results['program']): ?>
            <div class="result-group">
                <h2>Program <span>(<?= count($results['program']) ?>)</span></h2>
                <?php foreach ($results['program'] as $r): ?>
                <a class="result-item" href="program.php">
                    <h3><?= e($r['judul']) ?></h3>
                    <p><?= e($r['deskripsi']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($results['mapel']): ?>
            <div class="result-group">
                <h2>Mata Pelajaran <span>(<?= count($results['mapel']) ?>)</span></h2>
                <?php foreach ($results['mapel'] as $r): ?>
                <a class="result-item" href="mapel.php">
                    <h3><?= e($r['nama']) ?></h3>
                    <p><?= e($r['deskripsi']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($results['asatidz']): ?>
            <div class="result-group">
                <h2>Asatidz & Staff <span>(<?= count($results['asatidz']) ?>)</span></h2>
                <?php foreach ($results['asatidz'] as $r): ?>
                <a class="result-item" href="asatidz.php">
                    <small><?= e($r['kategori'] === 'asatidz' ? 'Asatidz' : 'Staff') ?></small>
                    <h3><?= e($r['nama']) ?></h3>
                    <p><?= e($r['bidang']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($results['kalender']): ?>
            <div class="result-group">
                <h2>Kalender Akademik <span>(<?= count($results['kalender']) ?>)</span></h2>
                <?php foreach ($results['kalender'] as $r): ?>
                <a class="result-item" href="kalender.php#kal-<?= (int) $r['id'] ?>">
                    <small><?= e($r['kategori']) ?> &bull; <?= e(tgl_id($r['tanggal_mulai'])) ?></small>
                    <h3><?= e($r['judul']) ?></h3>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($results['galeri']): ?>
            <div class="result-group">
                <h2>Galeri <span>(<?= count($results['galeri']) ?>)</span></h2>
                <?php foreach ($results['galeri'] as $r): ?>
                <a class="result-item" href="galeri.php">
                    <small><?= e($r['kategori']) ?></small>
                    <h3><?= e($r['judul']) ?></h3>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
