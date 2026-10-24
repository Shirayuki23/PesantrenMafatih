<?php
// Include ini membutuhkan variabel:
// $page_title, $page_css, $active (beranda|profil|visi-misi|asatidz|prestasi|program|mapel|kalender|download|berita|berita-detail|galeri|faq|pendaftaran|kontak|cari|sitemap)
// $base (opsional): prefix direktori untuk halaman di subfolder, contoh '../'
// $crumbs (opsional): daftar breadcrumb, contoh [['label'=>'Kalender Akademik']]
require_once __DIR__ . '/../config/database.php';
$active = $active ?? '';
$base = $base ?? '';
function nav_active(string $key, string $active): string
{
    return $key === $active ? ' class="active"' : '';
}
// Render breadcrumb; Beranda selalu jadi titik awal.
function crumbs_html(array $crumbs): string
{
    if (!$crumbs) {
        return '';
    }
    global $base;
    $last = array_key_last($crumbs);
    $html = '<div class="crumb-bar"><div class="container breadcrumb">';
    $html .= '<a href="' . e($base) . 'index.php">Beranda</a>';
    foreach ($crumbs as $i => $c) {
        $html .= ' <i>/</i> ';
        if ($i === $last) {
            $html .= '<span>' . e($c['label']) . '</span>';
        } else {
            $html .= '<a href="' . e($base . ($c['href'] ?? '')) . '">' . e($c['label']) . '</a>';
        }
    }
    return $html . '</div></div>';
}
// Penghitung kunjungan: satu hit per sesi.
if (empty($_SESSION['hit_counted'])) {
    db()->exec('UPDATE kunjungan SET jumlah = jumlah + 1 WHERE id = 1');
    $_SESSION['hit_counted'] = true;
}
$flash = flash_get();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title ?? 'Pesantren Mafatih Wanayasa') ?></title>
  <meta name="description" content="Website resmi <?= e(pengaturan('nama_pesantran', 'Pesantren Mafatih Wanayasa')) ?>.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Amiri:wght@700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= e($base) ?>assets/img/logo-mafatih.png">
  <link rel="stylesheet" href="<?= e($base) ?>assets/css/main.css?<?= ver('assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= e($base) ?>assets/css/<?= e($page_css ?? 'index.css') ?>?<?= ver('assets/css/' . ($page_css ?? 'index.css')) ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<?php if ($flash): ?>
  <div class="toast toast-<?= e($flash['type']) ?>" id="flashToast"><?= e($flash['msg']) ?></div>
<?php endif; ?>
  <header class="header-wrapper">
    <div class="top-bar">
      <div class="container top-container">
        <div class="welcome-marquee">
          <div class="marquee-text"><?= e(pengaturan('marquee_teks')) ?></div>
        </div>
        <div class="social-top">
          <a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a>
          <a href="#"><i class="fa-brands fa-youtube"></i> YouTube</a>
          <a href="#"><i class="fa-brands fa-tiktok"></i> TikTok</a>
        </div>
      </div>
    </div>
    <div class="main-header">
      <div class="container header-container">
        <div class="header-logo">
          <a href="<?= e($base) ?>index.php">
            <img class="logo-img" src="<?= e($base) ?>assets/img/logo-mafatih.png" alt="Logo Pesantren Mafatih">
            <div class="logo-text">
              <strong>MAFATIH</strong>
              <span>Pesantren Wanayasa</span>
            </div>
          </a>
        </div>
        <div class="main-menu" id="mainMenu">
          <ul>
            <li><a href="<?= e($base) ?>index.php"<?= nav_active('beranda', $active) ?>>Beranda</a></li>
            <li class="has-sub<?= in_array($active, ['profil', 'visi-misi', 'asatidz', 'prestasi'], true) ? ' open' : '' ?>">
              <a href="#" class="profile-link">Tentang <span>▾</span></a>
              <ul class="sub-menu">
                <li><a href="<?= e($base) ?>profil.php">Tentang Pesantren</a></li>
                <li><a href="<?= e($base) ?>visi-misi.php">Visi &amp; Misi</a></li>
                <li><a href="<?= e($base) ?>asatidz.php">Data Asatidz &amp; Staff</a></li>
                <li><a href="<?= e($base) ?>prestasi.php">Prestasi Santri</a></li>
              </ul>
            </li>
            <li class="has-sub<?= in_array($active, ['program', 'mapel', 'kalender', 'download'], true) ? ' open' : '' ?>">
              <a href="#" class="akademik-link">Akademik <span>▾</span></a>
              <ul class="sub-menu">
                <li><a href="<?= e($base) ?>program.php">Program</a></li>
                <li><a href="<?= e($base) ?>mapel.php">Mata Pelajaran</a></li>
                <li><a href="<?= e($base) ?>kalender.php">Kalender Akademik</a></li>
                <li><a href="<?= e($base) ?>download.php">Download Berkas</a></li>
              </ul>
            </li>
            <li><a href="<?= e($base) ?>berita.php"<?= nav_active('berita', $active) . nav_active('berita-detail', $active) ?>>Berita</a></li>
            <li><a href="<?= e($base) ?>galeri.php"<?= nav_active('galeri', $active) ?>>Galeri</a></li>
            <li><a href="<?= e($base) ?>faq.php"<?= nav_active('faq', $active) ?>>FAQ</a></li>
            <li><a href="<?= e($base) ?>kontak.php"<?= nav_active('kontak', $active) ?>>Kontak</a></li>
          </ul>
        </div>
        <div class="header-actions">
          <a class="btn primary header-cta" href="<?= e($base) ?>pendaftaran.php">Daftar Sekarang</a>
          <button class="search-btn" id="searchBtn" aria-label="Cari">⌕</button>
          <button class="dark-btn" id="darkBtn" aria-label="Mode gelap">☾</button>
          <button class="menu-btn" id="menuToggle" aria-label="Menu">☰</button>
        </div>
      </div>
    </div>
    <div class="mobile-menu" id="mobileMenu">
      <a href="<?= e($base) ?>index.php">Beranda</a>
      <div class="mobile-dropdown">
        <button type="button">Tentang <span>▾</span></button>
        <div class="mobile-submenu">
          <a href="<?= e($base) ?>profil.php">Tentang Pesantren</a>
          <a href="<?= e($base) ?>visi-misi.php">Visi &amp; Misi</a>
          <a href="<?= e($base) ?>asatidz.php">Data Asatidz &amp; Staff</a>
          <a href="<?= e($base) ?>prestasi.php">Prestasi Santri</a>
        </div>
      </div>
      <div class="mobile-dropdown">
        <button type="button">Akademik <span>▾</span></button>
        <div class="mobile-submenu">
          <a href="<?= e($base) ?>program.php">Program</a>
          <a href="<?= e($base) ?>mapel.php">Mata Pelajaran</a>
          <a href="<?= e($base) ?>kalender.php">Kalender Akademik</a>
          <a href="<?= e($base) ?>download.php">Download Berkas</a>
        </div>
      </div>
      <a href="<?= e($base) ?>berita.php">Berita</a>
      <a href="<?= e($base) ?>galeri.php">Galeri</a>
      <a href="<?= e($base) ?>faq.php">FAQ</a>
      <a href="<?= e($base) ?>kontak.php">Kontak</a>
      <a href="<?= e($base) ?>sitemap.php">Peta Situs</a>
      <a class="btn primary" href="<?= e($base) ?>pendaftaran.php">Daftar Sekarang</a>
    </div>
  </header>
  <div class="search-overlay" id="searchOverlay">
    <form class="search-box" action="<?= e($base) ?>cari.php" method="get">
      <input type="search" name="q" placeholder="Cari berita, program, kalender akademik..." required minlength="2">
      <button type="submit" class="btn primary">Cari</button>
      <button type="button" class="search-close" id="searchClose" aria-label="Tutup">✕</button>
    </form>
  </div>
