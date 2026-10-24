<?php
$active = 'galeri';
$page_title = 'Galeri - Pesantren Mafatih Wanayasa';
$page_css = 'Galeri.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Galeri']];

$galeri = db()->query('SELECT kategori, judul, gambar, ukuran FROM galeri ORDER BY urutan')->fetchAll();
$kats = array_values(array_unique(array_column($galeri, 'kategori')));
$imgClasses = ['image-one', 'image-two', 'image-three', 'image-four', 'image-five', 'image-six'];
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>DOKUMENTASI KEGIATAN</span>
                <h1>Galeri Mafatih</h1>
                <p>
                    Dokumentasi berbagai kegiatan, pembelajaran, dan aktivitas
                    santri <?= e(pengaturan('nama_pesantran')) ?>.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>

        <?php $carousel_items = array_slice($galeri, 0, 6); $carousel_label = 'SOROTAN'; $carousel_title = 'Momen Pilihan'; $carousel_cta = '';
              require __DIR__ . '/includes/gallery_carousel.php'; ?>

        <section class="gallery-section">
            <div class="section-heading">
                <div>
                    <span>GALERI KEGIATAN</span>
                    <h2>Momen di Pesantren Mafatih</h2>
                </div>
                <p>
                    Beberapa dokumentasi kegiatan yang dilakukan oleh santri
                    dan keluarga besar Pesantren Mafatih. Klik salah satu foto untuk memperbesar.
                </p>
            </div>

            <div class="chip-row" data-filter-group="#galleryGrid">
                <button class="chip active" data-cat="">Semua</button>
                <?php foreach ($kats as $k): ?>
                <button class="chip" data-cat="<?= e($k) ?>"><?= e($k) ?></button>
                <?php endforeach; ?>
            </div>

            <div class="gallery-container" id="galleryGrid">
                <?php foreach ($galeri as $i => $g): ?>
                <article class="gallery-item<?= $g['ukuran'] === 'besar' ? ' large' : '' ?> reveal"
                         data-cat="<?= e($g['kategori']) ?>" data-title="<?= e($g['judul']) ?>">
                    <?php if ($g['gambar']): ?>
                    <img class="gallery-image" src="<?= e($g['gambar']) ?>" alt="<?= e($g['judul']) ?>">
                    <?php else: ?>
                    <div class="gallery-image gi-grad <?= $imgClasses[$i % 6] ?>">
                        <div class="image-overlay">
                            <span><?= e($g['kategori']) ?></span>
                            <h3><?= e($g['judul']) ?></h3>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="gallery-info">
            <div class="info-number"><?= str_pad((string) count($galeri), 2, '0', STR_PAD_LEFT) ?></div>
            <div>
                <span>DOKUMENTASI</span>
                <h2>Setiap Kegiatan<br>Memiliki Cerita</h2>
            </div>
            <p>
                Galeri ini menjadi dokumentasi berbagai kegiatan yang
                menggambarkan aktivitas pendidikan, keagamaan, sosial,
                dan kebersamaan di <?= e(pengaturan('nama_pesantran')) ?>.
            </p>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
