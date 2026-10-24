<?php
// Carousel galeri yang bisa dipakai di banyak halaman.
// Varian input: $carousel_items (baris: kategori, judul, gambar), $carousel_label, $carousel_title,
// $carousel_cta (URL tombol kanan, '' untuk menyembunyikan)
$items = $carousel_items ?? [];
if (!$items) {
    return;
}
$label = $carousel_label ?? 'DOKUMENTASI';
$judul = $carousel_title ?? 'Galeri Kegiatan';
$cta = $carousel_cta ?? 'galeri.php';
$grads = ['gc-1', 'gc-2', 'gc-3', 'gc-4', 'gc-5', 'gc-6'];
?>
        <section class="gal-carousel-sec">
            <div class="container">
                <div class="section-head">
                    <div>
                        <p class="section-label"><?= e($label) ?></p>
                        <h2><?= e($judul) ?></h2>
                    </div>
                    <?php if ($cta !== ''): ?><a class="small-btn" href="<?= e($cta) ?>">Semua Galeri</a><?php endif; ?>
                </div>
                <div class="gal-carousel" data-carousel>
                    <div class="gc-viewport">
                        <div class="gc-track">
                            <?php foreach ($items as $i => $g): ?>
                            <div class="gc-slide">
                                <?php if ($g['gambar']): ?>
                                <img src="<?= e($g['gambar']) ?>" alt="<?= e($g['judul']) ?>">
                                <?php else: ?>
                                <div class="gc-grad <?= $grads[$i % 6] ?>"></div>
                                <?php endif; ?>
                                <div class="gc-caption">
                                    <span><?= e($g['kategori']) ?></span>
                                    <h3><?= e($g['judul']) ?></h3>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button class="gc-arrow gc-prev" type="button" aria-label="Sebelumnya">&#8592;</button>
                    <button class="gc-arrow gc-next" type="button" aria-label="Berikutnya">&#8594;</button>
                    <div class="gc-dots" role="tablist"></div>
                </div>
            </div>
        </section>
