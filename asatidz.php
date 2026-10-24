<?php
$active = 'asatidz';
$page_title = 'Asatidz & Staff - Pesantren Mafatih Wanayasa';
$page_css = 'Asatidz.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Data Asatidz & Staff']];

$st = db()->prepare('SELECT kategori, nama, bidang, foto FROM asatidz_staff WHERE kategori = ? ORDER BY urutan');
$st->execute(['asatidz']);
$asatidz = $st->fetchAll();
$st->execute(['staff']);
$staff = $st->fetchAll();
?>
    <main>
        <section class="staff-hero">
            <div class="hero-decoration"></div>

            <div class="staff-hero-content">
                <span>ORANG-ORANG DI BALIK PENDIDIKAN</span>
                <h1>Asatidz & Staff</h1>
                <p>
                    Mengenal para pendidik dan tenaga pendukung yang berperan
                    dalam kegiatan pendidikan di <?= e(pengaturan('nama_pesantran')) ?>.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>

        <section class="staff-section">
            <div class="section-heading">
                <div>
                    <span>ASATIDZ</span>
                    <h2>Para Pendidik</h2>
                </div>

                <p>
                    Para asatidz mendampingi santri dalam proses pembelajaran
                    dan pembinaan di lingkungan pesantren.
                </p>
            </div>

            <div class="staff-carousel" id="staffCarousel">
                <div class="staff-grid">
                    <?php foreach ($asatidz as $a): ?>
                    <article class="staff-card">
                        <div class="staff-photo">
                            <img src="<?= e($a['foto']) ?>" alt="<?= e($a['nama']) ?>">
                        </div>

                        <div class="staff-info">
                            <span><?= $a['kategori'] === 'asatidz' ? 'PENGAJAR' : 'STAFF' ?></span>
                            <h3><?= e($a['nama']) ?></h3>
                            <p><?= e($a['bidang']) ?></p>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="carousel-dots">
                <?php for ($i = 0; $i < max(count($asatidz), 1); $i++): ?>
                <button class="dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>"></button>
                <?php endfor; ?>
            </div>
        </section>

        <section class="staff-section staff-bg">
            <div class="section-heading">
                <div>
                    <span>STAFF</span>
                    <h2>Tenaga Pendukung</h2>
                </div>

                <p>
                    Staff membantu memastikan kegiatan administrasi dan
                    operasional pesantren berjalan dengan baik.
                </p>
            </div>

            <div class="staff-grid staff-grid-small">
                <?php foreach ($staff as $s): ?>
                <article class="staff-card">
                    <div class="staff-photo">
                        <img src="<?= e($s['foto']) ?>" alt="<?= e($s['nama']) ?>">
                    </div>

                    <div class="staff-info">
                        <span>STAFF</span>
                        <h3><?= e($s['nama']) ?></h3>
                        <p><?= e($s['bidang']) ?></p>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
    