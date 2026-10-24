<?php
// Footer umum untuk seluruh halaman. Variabel: $active, $base (lihat header.php)
$active = $active ?? '';
$base = $base ?? '';
?>
  <footer class="footer">
    <div class="container footer-grid">
      <div class="footer-col">
        <div class="brand footer-brand">
          <img class="brand-logo" src="<?= e($base) ?>assets/img/logo-mafatih.png" alt="Logo Pesantren Mafatih">
          <div>
            <strong>MAFATIH</strong>
            <span>Pesantren Wanayasa</span>
          </div>
        </div>
        <p><?= e(pengaturan('nama_pesantran')) ?> — lembaga pendidikan Islam yang memadukan tahfizh, ilmu, dan pembentukan karakter.</p>
      </div>
      <div class="footer-col">
        <h4>Navigasi</h4>
        <div class="footer-nav-grid">
          <a href="<?= e($base) ?>index.php">Beranda</a>
          <a href="<?= e($base) ?>profil.php">Profil</a>
          <a href="<?= e($base) ?>visi-misi.php">Visi &amp; Misi</a>
          <a href="<?= e($base) ?>prestasi.php">Prestasi</a>
          <a href="<?= e($base) ?>program.php">Program</a>
          <a href="<?= e($base) ?>kalender.php">Kalender</a>
          <a href="<?= e($base) ?>download.php">Download</a>
          <a href="<?= e($base) ?>berita.php">Berita</a>
          <a href="<?= e($base) ?>galeri.php">Galeri</a>
          <a href="<?= e($base) ?>faq.php">FAQ</a>
          <a href="<?= e($base) ?>kontak.php">Kontak</a>
          <a href="<?= e($base) ?>sitemap.php">Peta Situs</a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Pendaftaran</h4>
        <p>Penerimaan santri baru dibuka sepanjang tahun selama kuota masih tersedia.</p>
        <a class="btn outline light" href="<?= e($base) ?>pendaftaran.php">Formulir PPDB →</a>
      </div>
      <div class="footer-col">
        <h4>Kontak</h4>
        <p><i class="fa-solid fa-location-dot"></i> <?= e(pengaturan('alamat')) ?></p>
        <p><i class="fa-regular fa-envelope"></i> <?= e(pengaturan('email', 'via formulir kontak resmi')) ?></p>
        <?php if (pengaturan('wa_number') !== ''): ?>
        <p><i class="fa-brands fa-whatsapp"></i> <a href="https://wa.me/<?= e(preg_replace('/\D/', '', pengaturan('wa_number'))) ?>" target="_blank" rel="noopener"><?= e(pengaturan('wa_number')) ?></a></p>
        <?php endif; ?>
        <div class="social-top footer-social">
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-youtube"></i></a>
          <a href="#"><i class="fa-brands fa-tiktok"></i></a>
        </div>
      </div>
    </div>
    <div class="copyright">© <span id="year"></span> <?= e(pengaturan('nama_pesantran')) ?>. Semua hak dilindungi.</div>
  </footer>
  <button class="to-top" id="toTop" aria-label="Kembali ke atas">↑</button>
  <?php if (pengaturan('wa_number') !== ''): ?>
  <a class="wa-float" href="https://wa.me/<?= e(preg_replace('/\D/', '', pengaturan('wa_number'))) ?>?text=<?= rawurlencode("Assalamu'alaikum, saya ingin bertanya tentang Pesantren Mafatih") ?>" target="_blank" rel="noopener" aria-label="Chat WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
  <?php endif; ?>
  <div class="lightbox" id="lightbox">
    <button class="lightbox-close" id="lightboxClose" aria-label="Tutup">✕</button>
    <div class="lightbox-body" id="lightboxBody"></div>
    <p class="lightbox-caption" id="lightboxCaption"></p>
  </div>
  <script src="<?= e($base) ?>assets/js/main.js?<?= ver('assets/js/main.js') ?>"></script>
</body>
</html>
