<?php
$active = 'beranda';
$page_title = 'Beranda - Pesantren Mafatih Wanayasa';
$page_css = 'index.css';
require __DIR__ . '/includes/header.php';

$programs = db()->query("SELECT judul, deskripsi FROM program WHERE tampil_di IN ('beranda','keduanya') ORDER BY urutan")->fetchAll();
$berita = db()->query('SELECT id, kategori, judul, deskripsi, gambar FROM berita ORDER BY tanggal DESC LIMIT 3')->fetchAll();
$testimoni = db()->query('SELECT nama, asal, isi FROM testimoni ORDER BY urutan')->fetchAll();
$carouselGaleri = db()->query('SELECT kategori, judul, gambar FROM galeri ORDER BY urutan LIMIT 6')->fetchAll();
$stats = [
    ['label' => 'Santri Aktif', 'value' => (int) db()->query("SELECT COUNT(*) FROM santri WHERE status = 'aktif'")->fetchColumn()],
    ['label' => 'Pengajar (Asatidz)', 'value' => (int) db()->query("SELECT COUNT(*) FROM asatidz_staff WHERE kategori = 'asatidz'")->fetchColumn()],
    ['label' => 'Staff', 'value' => (int) db()->query("SELECT COUNT(*) FROM asatidz_staff WHERE kategori = 'staff'")->fetchColumn()],
    ['label' => 'Program Unggulan', 'value' => (int) db()->query('SELECT COUNT(*) FROM program')->fetchColumn()],
    ['label' => 'Kunjungan Pengunjung', 'value' => (int) db()->query('SELECT jumlah FROM kunjungan WHERE id = 1')->fetchColumn(), 'suffix' => ''],
];
$agendaDepan = db()->query("SELECT id, judul, kategori, tanggal_mulai FROM kalender_akademik
                            WHERE COALESCE(tanggal_selesai, tanggal_mulai) >= CURDATE()
                            ORDER BY tanggal_mulai LIMIT 3")->fetchAll();
$imgClasses = ['img1', 'img2', 'img3'];
?>
  <main>
    <!-- HERO -->
    <section class="hero">
      <div class="hero-overlay"></div>
      <div class="orb orb-1"></div>
      <div class="orb orb-2"></div>
      <div class="container hero-content">
        <p class="eyebrow"><?= e(pengaturan('beranda_label')) ?></p>
        <h1>Membentuk Generasi<br><span>Qur'ani & Berkarakter</span></h1>
        <p class="hero-text"><?= e(pengaturan('beranda_teks')) ?></p>
        <div class="hero-buttons">
          <a class="btn primary" href="pendaftaran.php">Daftar Sekarang</a>
          <a class="btn outline" href="profil.php">Kenali Mafatih</a>
        </div>
      </div>
    </section>
    <!-- STATISTIK -->
    <section class="quick-stats">
      <div class="container stats-grid">
        <?php foreach ($stats as $s): ?>
        <div class="stat-box reveal">
          <b class="stat-num" data-count="<?= $s['value'] ?>" data-suffix="<?= e($s['suffix'] ?? '+') ?>">0</b>
          <span><?= e($s['label']) ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <!-- PROFIL SINGKAT -->
    <section class="section">
      <div class="container two-col">
        <div class="reveal">
          <p class="section-label">TENTANG KAMI</p>
          <h2>Selamat Datang di<br>Pesantren Mafatih</h2>
          <p class="muted"><?= e(pengaturan('beranda_tentang_1')) ?></p>
          <p class="muted"><?= e(pengaturan('beranda_tentang_2')) ?></p>
          <a class="text-link" href="profil.php">Selengkapnya tentang kami →</a>
        </div>
        <div class="profile-card reveal">
          <div class="card-icon">☪</div>
          <h3>Visi</h3>
          <p><?= e(pengaturan('beranda_visi')) ?></p>
          <div class="line"></div>
          <h3>Misi</h3>
          <p><?= e(pengaturan('beranda_misi')) ?></p>
        </div>
      </div>
    </section>
    <!-- PROGRAM -->
    <section class="section light">
      <div class="container">
        <div class="section-head">
          <div>
            <p class="section-label">PROGRAM UNGGULAN</p>
            <h2>Pendidikan yang Menyeluruh</h2>
          </div>
          <p class="muted head-desc">Membangun kemampuan akademik sekaligus membentuk akhlak dan kepemimpinan santri.</p>
        </div>
        <div class="program-grid">
          <?php foreach ($programs as $i => $p): ?>
          <article class="program-card reveal">
            <span><?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <h3><?= e($p['judul']) ?></h3>
            <p><?= e($p['deskripsi']) ?></p>
          </article>
          <?php endforeach; ?>
        </div>
        <div class="center-button">
          <a class="btn primary" href="program.php">Lihat Semua Program</a>
        </div>
      </div>
    </section>
    <!-- BERITA -->
    <section class="section">
      <div class="container">
        <div class="section-head">
          <div>
            <p class="section-label">INFORMASI TERKINI</p>
            <h2>Berita & Kegiatan</h2>
          </div>
          <a class="small-btn" href="berita.php">Lihat Semua</a>
        </div>
        <div class="news-grid">
          <?php foreach ($berita as $i => $b): ?>
          <a class="news-card reveal" href="berita_detail.php?id=<?= (int) $b['id'] ?>">
            <div class="news-img <?= e($imgClasses[$i % 3]) ?>"<?= $b['gambar'] ? ' style="background-image:url(\'' . e($b['gambar']) . '\')"' : '' ?>>
              <?= e(strtok($b['kategori'], ' ')) ?>
            </div>
            <div class="news-body">
              <small><?= e($b['kategori']) ?></small>
              <h3><?= e($b['judul']) ?></h3>
              <p><?= e($b['deskripsi']) ?></p>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php if ($agendaDepan): ?>
    <!-- AGENDA KALENDER -->
    <section class="section agenda-sec">
      <div class="container">
        <div class="section-head">
          <div>
            <p class="section-label">KALENDER AKADEMIK</p>
            <h2>Agenda Terdekat</h2>
          </div>
          <a class="small-btn" href="kalender.php">Lihat Kalender</a>
        </div>
        <div class="agenda-grid">
          <?php foreach ($agendaDepan as $ag): $ts = strtotime($ag['tanggal_mulai']); ?>
          <a class="agenda-card reveal" href="kalender.php#kal-<?= (int) $ag['id'] ?>">
            <div class="agenda-date">
              <b><?= (int) date('j', $ts) ?></b>
              <span><?= ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][(int) date('n', $ts) - 1] ?></span>
            </div>
            <div class="agenda-info">
              <small><?= e($ag['kategori']) ?></small>
              <strong><?= e($ag['judul']) ?></strong>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <!-- GALERI CAROUSEL -->
    <?php $carousel_items = $carouselGaleri; $carousel_label = 'MOMEN PESANTREN'; $carousel_title = 'Galeri Kegiatan Santri';
          require __DIR__ . '/includes/gallery_carousel.php'; ?>
    <!-- TESTIMONI -->
    <?php if ($testimoni): ?>
    <section class="section light">
      <div class="container">
        <div class="section-head">
          <div>
            <p class="section-label">TESTIMONI</p>
            <h2>Kata Wali Santri & Alumni</h2>
          </div>
        </div>
        <div class="slider reveal" data-slider>
          <div class="slides">
            <?php foreach ($testimoni as $i => $t): ?>
            <blockquote class="slide<?= $i === 0 ? ' active' : '' ?>">
              <p>"<?= e($t['isi']) ?>"</p>
              <footer>
                <div class="avatar"><?= e(mb_substr($t['nama'], 0, 1)) ?></div>
                <div>
                  <strong><?= e($t['nama']) ?></strong>
                  <span><?= e($t['asal']) ?></span>
                </div>
              </footer>
            </blockquote>
            <?php endforeach; ?>
          </div>
          <div class="slider-dots"></div>
        </div>
      </div>
    </section>
    <?php endif; ?>
    <!-- CTA PENDAFTARAN -->
    <section class="cta-band">
      <div class="container cta-inner reveal">
        <div>
          <h2>Siap Menjadi Bagian dari Mafatih?</h2>
          <p>Pendaftaran santri baru dibuka sepanjang tahun. Isi formulirnya, tim kami akan menghubungi Anda.</p>
        </div>
        <div class="cta-actions">
          <a class="btn outline light" href="pendaftaran.php">Formulir Pendaftaran</a>
          <a class="btn outline light" href="faq.php">Pelajari Dulu (FAQ)</a>
        </div>
      </div>
    </section>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
