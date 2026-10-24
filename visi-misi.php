<?php
$active = 'visi-misi';
$page_title = 'Visi & Misi - Pesantren Mafatih Wanayasa';
$page_css = 'Visi-misi.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Visi & Misi']];

$visi = db()->query('SELECT pernyataan, deskripsi FROM visi LIMIT 1')->fetch();
$misi = db()->query('SELECT judul, isi FROM misi ORDER BY urutan')->fetchAll();
?>
    <main>
        <section class="vm-hero">
            <div class="vm-hero-content">
                <span>ARAH & TUJUAN</span>
                <h1>Visi & Misi</h1>
                <p>
                    Landasan yang menjadi arah dalam penyelenggaraan pendidikan
                    dan pembinaan santri di <?= e(pengaturan('nama_pesantran')) ?>.
                </p>
            </div>
            <div class="hero-symbol">M</div>
        </section>
        <?= crumbs_html($crumbs) ?>

        <section class="vision-section">
            <div class="vision-label">
                <span>01</span>
                <p>VISI PESANTREN</p>
            </div>
            <div class="vision-content">
                <h2>"<?= e($visi['pernyataan'] ?? '') ?>"</h2>
                <p><?= e($visi['deskripsi'] ?? '') ?></p>
            </div>
        </section>

        <section class="mission-section">
            <div class="mission-heading">
                <span>02</span>
                <div>
                    <p>LANGKAH KAMI</p>
                    <h2>Misi Pesantren</h2>
                </div>
            </div>

            <div class="mission-list">
                <?php foreach ($misi as $i => $m): ?>
                <div class="mission-item">
                    <div class="mission-number"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <div class="mission-text">
                        <h3><?= e($m['judul']) ?></h3>
                        <p><?= e($m['isi']) ?></p>
                    </div>
                    <div class="mission-arrow">↗</div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="principle-section">
            <div class="principle-box">
                <span>PRINSIP PENDIDIKAN</span>
                <h2>Ilmu, Akhlak, dan Kemandirian</h2>
                <p>
                    Ketiga nilai tersebut menjadi bagian penting dalam proses
                    pendidikan dan pembinaan santri di lingkungan pesantren.
                </p>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
    