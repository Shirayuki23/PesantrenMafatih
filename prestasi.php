<?php
$active = 'prestasi';
$page_title = 'Prestasi Santri - Pesantren Mafatih Wanayasa';
$page_css = 'Prestasi.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Prestasi Santri']];

$prestasi = db()->query('SELECT id, judul, peraih, tingkat, deskripsi, tanggal FROM prestasi ORDER BY tanggal DESC, urutan')->fetchAll();
$totalPrestasi = count($prestasi);
$tingkatCount = array_count_values(array_column($prestasi, 'tingkat'));
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>TOREHAN PRESTASI</span>
                <h1>Prestasi Santri</h1>
                <p>Banggungan <?= e(pengaturan('nama_pesantran')) ?> atas setiap usaha santri dalam kompetisi akademik maupun keagamaan.</p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content prest-wrap">
            <div class="prest-summary reveal">
                <div class="prest-sum-item"><b><?= $totalPrestasi ?></b><span>Total Torehan</span></div>
                <?php foreach (['Nasional' => '🏆', 'Provinsi' => '🥇', 'Kabupaten' => '🥈'] as $t => $ico): ?>
                <div class="prest-sum-item"><b><?= (int) ($tingkatCount[$t] ?? 0) ?></b><span><?= $ico ?> Tingkat <?= e($t) ?></span></div>
                <?php endforeach; ?>
            </div>
            <div class="prest-grid">
                <?php foreach ($prestasi as $p): ?>
                <article class="prest-card reveal">
                    <div class="prest-medal"><i class="fa-solid fa-trophy"></i></div>
                    <span class="prest-tingkat tk-<?= e(strtolower($p['tingkat'])) ?>"><?= e($p['tingkat']) ?></span>
                    <h3><?= e($p['judul']) ?></h3>
                    <p class="prest-peraih"><i class="fa-regular fa-user"></i> <?= e($p['peraih']) ?></p>
                    <p class="prest-desc"><?= e($p['deskripsi']) ?></p>
                    <small class="prest-tgl"><i class="fa-regular fa-calendar"></i> <?= e(tgl_id($p['tanggal'])) ?></small>
                </article>
                <?php endforeach; ?>
                <?php if (!$prestasi): ?><p class="muted">Belum ada prestasi yang dipublikasikan.</p><?php endif; ?>
            </div>
            <div class="cta-actions prest-cta reveal">
                <a class="btn primary" href="pendaftaran.php">Daftar Jadi Santri</a>
                <a class="btn outline dark" href="kalender.php">Lihat Kalender Akademik</a>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
