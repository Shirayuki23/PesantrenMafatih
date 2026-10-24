<?php
$active = 'mapel';
$page_title = 'Mata Pelajaran - Pesantren Mafatih Wanayasa';
$page_css = 'Mapel.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Mata Pelajaran']];

$mapel = db()->query('SELECT nama, deskripsi, ikon, is_featured FROM mata_pelajaran ORDER BY urutan')->fetchAll();
?>
    <main>
        <section class="subject-hero">
            <div class="hero-number">04</div>
            <div class="subject-hero-content">
                <span>KURIKULUM PEMBELAJARAN</span>
                <h1>Mata<br><strong>Pelajaran</strong></h1>
                <p>
                    Berbagai mata pelajaran yang mendukung pendidikan agama,
                    akademik, karakter, dan pengembangan kemampuan santri.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="subject-intro">
            <div class="intro-label">PEMBELAJARAN</div>
            <div class="intro-content">
                <h2>Belajar ilmu agama dan ilmu umum secara seimbang.</h2>
                <p>
                    Pembelajaran di Pesantren Mafatih memadukan pendidikan
                    keagamaan dengan pengetahuan umum untuk membantu santri
                    berkembang secara akademik dan berkarakter.
                </p>
            </div>
        </section>
        <section class="subject-section">
            <div class="subject-heading">
                <span>DAFTAR PELAJARAN</span>
                <h2>Materi yang Dipelajari</h2>
            </div>
            <div class="subject-grid">
                <?php foreach ($mapel as $i => $m): ?>
                <article class="subject-card<?= $m['is_featured'] ? ' featured' : '' ?>">
                    <div class="subject-number"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <div class="subject-icon"><?= e($m['ikon']) ?></div>
                    <h3><?= e($m['nama']) ?></h3>
                    <p><?= e($m['deskripsi']) ?></p>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="learning-banner">
            <div>
                <span>PROSES PENDIDIKAN</span>
                <h2>Ilmu, karakter, dan keterampilan berjalan bersama.</h2>
            </div>
            <a href="program.php">Lihat Program →</a>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
    