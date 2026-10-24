<?php
require_once __DIR__ . '/layout.php';
admin_boot();

$counts = [
    ['Berita', 'berita', '', 'crud.php?ent=berita', 'fa-newspaper'],
    ['Galeri', 'galeri', '', 'crud.php?ent=galeri', 'fa-images'],
    ['FAQ', 'faq', '', 'crud.php?ent=faq', 'fa-circle-question'],
    ['Testimoni', 'testimoni', '', 'crud.php?ent=testimoni', 'fa-quote-left'],
    ['Program', 'program', '', 'crud.php?ent=program', 'fa-seedling'],
    ['Kalender', 'kalender_akademik', '', 'crud.php?ent=kalender', 'fa-calendar-days'],
    ['Santri Aktif', 'santri', "WHERE status = 'aktif'", 'crud.php?ent=santri', 'fa-user-graduate'],
    ['Prestasi', 'prestasi', '', 'crud.php?ent=prestasi', 'fa-trophy'],
    ['Berkas', 'berkas', '', 'crud.php?ent=berkas', 'fa-file-arrow-down'],
    ['Pesan Masuk', 'pesan_kontak', '', 'pesan.php?t=pesan', 'fa-envelope'],
    ['Pendaftaran', 'pendaftaran', '', 'pesan.php?t=pendaftaran', 'fa-user-plus'],
];
$latestPesan = db()->query('SELECT nama, subjek, created_at FROM pesan_kontak ORDER BY id DESC LIMIT 5')->fetchAll();
$latestPPDB = db()->query('SELECT nama_santri, status, created_at FROM pendaftaran ORDER BY id DESC LIMIT 5')->fetchAll();

admin_header('Dashboard', 'dashboard');
?>
<div class="cards">
  <?php foreach ($counts as [$label, $table, $where, $href, $ico]): ?>
  <a class="card" href="<?= e($href) ?>">
    <div class="ico"><i class="fa-solid <?= $ico ?>"></i></div>
    <b><?= (int) db()->query("SELECT COUNT(*) FROM {$table} {$where}")->fetchColumn() ?></b>
    <span><?= e($label) ?></span>
  </a>
  <?php endforeach; ?>
</div>

<div class="dash-cols">
  <section class="panel">
    <h2>Pesan terbaru</h2>
    <?php if (!$latestPesan): ?><p class="muted">Belum ada pesan.</p><?php endif; ?>
    <?php foreach ($latestPesan as $p): ?>
    <div class="row-item">
      <div><strong><?= e($p['nama']) ?></strong> <small><?= e($p['subjek']) ?></small></div>
      <time><?= e(tgl_id(substr($p['created_at'], 0, 10))) ?></time>
    </div>
    <?php endforeach; ?>
  </section>
  <section class="panel">
    <h2>Pendaftaran terbaru</h2>
    <?php if (!$latestPPDB): ?><p class="muted">Belum ada pendaftar.</p><?php endif; ?>
    <?php foreach ($latestPPDB as $p): ?>
    <div class="row-item">
      <div><strong><?= e($p['nama_santri']) ?></strong> <span class="badge b-<?= e($p['status']) ?>"><?= e($p['status']) ?></span></div>
      <time><?= e(tgl_id(substr($p['created_at'], 0, 10))) ?></time>
    </div>
    <?php endforeach; ?>
  </section>
</div>
<?php admin_footer(); ?>
