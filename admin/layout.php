<?php
// Layout + guard untuk semua halaman admin.
require_once __DIR__ . '/../config/database.php';

function admin_boot(): void
{
    if (empty($_SESSION['admin'])) {
        header('Location: login.php');
        exit;
    }
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf'] ?? '')) {
        http_response_code(400);
        die('Token keamanan tidak valid. Silakan coba lagi.');
    }
}

function admin_header(string $title, string $active = ''): void
{
    $menu = [
        'dashboard' => ['index.php', 'Dashboard', 'fa-gauge'],
        'berita' => ['crud.php?ent=berita', 'Berita', 'fa-newspaper'],
        'galeri' => ['crud.php?ent=galeri', 'Galeri', 'fa-images'],
        'faq' => ['crud.php?ent=faq', 'FAQ', 'fa-circle-question'],
        'testimoni' => ['crud.php?ent=testimoni', 'Testimoni', 'fa-quote-left'],
        'program' => ['crud.php?ent=program', 'Program', 'fa-seedling'],
        'kalender' => ['crud.php?ent=kalender', 'Kalender Akademik', 'fa-calendar-days'],
        'santri' => ['crud.php?ent=santri', 'Data Santri', 'fa-user-graduate'],
        'prestasi' => ['crud.php?ent=prestasi', 'Prestasi', 'fa-trophy'],
        'berkas' => ['crud.php?ent=berkas', 'Berkas Unduhan', 'fa-file-arrow-down'],
        'pesan' => ['pesan.php?t=pesan', 'Pesan & Pendaftaran', 'fa-inbox'],
        'pengaturan' => ['pengaturan.php', 'Pengaturan', 'fa-sliders'],
    ];
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title) ?> — Admin Mafatih</title>
  <link rel="stylesheet" href="../assets/css/admin.css?<?= ver('assets/css/admin.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="admin">
  <aside class="side">
    <div class="side-brand"><span>M</span> MAFATIH <small>admin</small></div>
    <nav>
      <?php foreach ($menu as $key => [$href, $label, $ico]): ?>
      <a href="<?= e($href) ?>" class="<?= $key === $active ? 'active' : '' ?>">
        <i class="fa-solid <?= $ico ?>"></i> <?= e($label) ?>
      </a>
      <?php endforeach; ?>
      <a href="../index.php"><i class="fa-solid fa-globe"></i> Lihat Situs</a>
      <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
    </nav>
  </aside>
  <main class="main">
    <header class="top">
      <h1><?= e($title) ?></h1>
      <span class="who"><?= e($_SESSION['admin'] ?? '') ?></span>
    </header>
    <?php $f = flash_get(); if ($f): ?>
    <div class="flash flash-<?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
    <?php endif; ?>
<?php
}

function admin_footer(): void
{
    echo "</main></body></html>";
}
