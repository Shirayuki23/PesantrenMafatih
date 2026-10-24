<?php
$active = 'faq';
$page_title = 'FAQ - Pesantren Mafatih Wanayasa';
$page_css = 'FAQ.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'FAQ']];

$faqs = db()->query('SELECT pertanyaan, jawaban FROM faq ORDER BY urutan')->fetchAll();
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>PERTANYAAN UMUM</span>
                <h1>FAQ Pesantren</h1>
                <p>
                    Jawaban singkat untuk pertanyaan yang paling sering
                    ditanyakan calon santri dan wali santri.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content faq-wrap">
            <div class="faq-list">
                <?php foreach ($faqs as $i => $f): ?>
                <div class="faq-item reveal<?= $i === 0 ? ' open' : '' ?>">
                    <button class="faq-q" type="button">
                        <span><?= e($f['pertanyaan']) ?></span>
                        <i>+</i>
                    </button>
                    <div class="faq-a">
                        <p><?= nl2br(e($f['jawaban'])) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php if (!$faqs): ?>
                <p class="muted">Belum ada pertanyaan yang dipublikasikan.</p>
                <?php endif; ?>
            </div>
            <aside class="faq-aside">
                <div class="faq-cta reveal">
                    <h3>Masih ada pertanyaan?</h3>
                    <p>Tim administrasi siap membantu Anda memilih program yang tepat untuk santri.</p>
                    <a class="btn primary" href="kontak.php">Hubungi Kami</a>
                    <a class="btn outline dark" href="pendaftaran.php">Daftar Sekarang</a>
                </div>
            </aside>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
