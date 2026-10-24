<?php
$active = 'program';
$page_title = 'Program - Pesantren Mafatih Wanayasa';
$page_css = 'Program.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Program']];

$programs = db()->query("SELECT judul, deskripsi, ikon FROM program WHERE tampil_di IN ('program','keduanya') ORDER BY urutan")->fetchAll();
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>PROGRAM PENDIDIKAN</span>
                <h1>Program Pesantren</h1>
                <p>
                    Berbagai program pendidikan dan kegiatan untuk membentuk
                    generasi yang berilmu dan berakhlak.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="content">
            <div class="section-title">
                <span>PROGRAM UNGGULAN</span>
                <h2>Kegiatan Pendidikan Mafatih</h2>
            </div>
            <div class="card-container">
                <?php foreach ($programs as $i => $p): ?>
                <article class="card">
                    <div class="card-number"><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></div>
                    <div class="card-icon"><?= e($p['ikon']) ?></div>
                    <h3><?= e($p['judul']) ?></h3>
                    <p><?= e($p['deskripsi']) ?></p>
                    <a href="#">Selengkapnya →</a>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
    