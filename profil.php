<?php
$active = 'profil';
$page_title = 'Tentang Pesantren - Pesantren Mafatih Wanayasa';
$page_css = 'Profil.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Tentang Pesantren']];

$sejarah = db()->query('SELECT judul, isi FROM sejarah ORDER BY urutan')->fetchAll();
$nilai = db()->query('SELECT judul, isi FROM nilai ORDER BY urutan')->fetchAll();
?>
    <main>
        <section class="profile-hero">
            <div class="profile-hero-content">
                <span>TENTANG PESANTREN</span>
                <h1>Mengenal Pesantren Mafatih</h1>
                <p>
                    Mengenal lebih dekat perjalanan, lingkungan, dan nilai pendidikan
                    yang menjadi dasar <?= e(pengaturan('nama_pesantran')) ?>.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="about-section">
            <div class="about-image">
                <img src="img/pesantren.jpg" alt="Pesantren Mafatih Wanayasa">
            </div>
            <div class="about-content">
                <span class="section-label">TENTANG KAMI</span>
                <h2>Tempat Belajar dan Bertumbuh</h2>
                <p>
                    Pesantren Mafatih Wanayasa merupakan lembaga pendidikan yang
                    mengembangkan pembelajaran keagamaan sekaligus membentuk karakter
                    dan akhlak para santri.
                </p>
                <p>
                    Lingkungan pesantren dirancang untuk memberikan pengalaman belajar
                    yang seimbang antara ilmu pengetahuan, nilai keislaman,
                    kedisiplinan, dan kehidupan sosial.
                </p>
            </div>
        </section>
        <section class="history-section">
            <div class="history-title">
                <span class="section-label">PERJALANAN KAMI</span>
                <h2>Sejarah Pesantren</h2>
            </div>
            <div class="history-content">
                <div class="history-line"></div>
                <?php foreach ($sejarah as $i => $s): ?>
                <div class="history-item">
                    <div class="history-number"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <div>
                        <h3><?= e($s['judul']) ?></h3>
                        <p><?= e($s['isi']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="values-section">
            <div class="section-heading">
                <span class="section-label">NILAI KAMI</span>
                <h2>Nilai yang Kami Bangun</h2>
            </div>
            <div class="values-grid">
                <?php foreach ($nilai as $i => $n): ?>
                <div class="value-card">
                    <div class="value-icon"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <h3><?= e($n['judul']) ?></h3>
                    <p><?= e($n['isi']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
    