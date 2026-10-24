<?php
require __DIR__ . '/config/database.php';

$active = 'kontak';
$page_title = 'Kontak - Pesantren Mafatih Wanayasa';
$page_css = 'Kontak.css';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subjek = trim($_POST['subjek'] ?? '');
    $pesan = trim($_POST['pesan'] ?? '');

    if ($nama === '') $errors[] = 'Nama wajib diisi.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
    if ($subjek === '') $errors[] = 'Subjek wajib diisi.';
    if ($pesan === '') $errors[] = 'Pesan wajib diisi.';

    if (!$errors) {
        $st = db()->prepare('INSERT INTO pesan_kontak (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)');
        $st->execute([$nama, $email, $subjek, $pesan]);
        flash_set('Pesan berhasil dikirim. Terima kasih sudah menghubungi Pesantren Mafatih.', 'success');
        header('Location: kontak.php');
        exit;
    }
}

$kontakInfo = db()->query('SELECT ikon, label, judul, isi FROM kontak_info ORDER BY urutan')->fetchAll();
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Kontak']];
?>
    <main>
        <section class="contact-hero">
            <div class="hero-content">
                <span>HUBUNGI KAMI</span>
                <h1>Mari Terhubung<br>Dengan Mafatih.</h1>
                <p>
                    Untuk informasi mengenai pesantren, program pendidikan,
                    pendaftaran, maupun pertanyaan lainnya, silakan hubungi
                    kami melalui informasi yang tersedia.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>
        <section class="contact-section">
            <div class="contact-intro">
                <span>INFORMASI KONTAK</span>
                <h2>Butuh informasi?</h2>
                <p>
                    Kami siap membantu memberikan informasi yang dibutuhkan
                    mengenai <?= e(pengaturan('nama_pesantran')) ?>.
                </p>
            </div>
            <div class="contact-layout">
                <div class="contact-info">
                    <?php foreach ($kontakInfo as $k): ?>
                    <div class="contact-card">
                        <div class="contact-icon"><?= e($k['ikon']) ?></div>
                        <div>
                            <small><?= e($k['label']) ?></small>
                            <h3><?= e($k['judul']) ?></h3>
                            <p><?= nl2br(e($k['isi'])) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="contact-form-box">
                    <div class="form-heading">
                        <span>KIRIM PESAN</span>
                        <h2>Ada yang ingin ditanyakan?</h2>
                        <p>
                            Isi formulir berikut untuk menyampaikan pesan
                            kepada pihak Pesantren Mafatih.
                        </p>
                    </div>
                    <?php if ($errors): ?>
                    <ul class="form-errors">
                        <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <form method="post" action="kontak.php" id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" placeholder="Masukkan nama" required
                                       value="<?= e($_POST['nama'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Masukkan email" required
                                       value="<?= e($_POST['email'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subjek">Subjek</label>
                            <input type="text" id="subjek" name="subjek" placeholder="Subjek pesan" required
                                   value="<?= e($_POST['subjek'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="pesan">Pesan</label>
                            <textarea id="pesan" name="pesan" rows="6" placeholder="Tulis pesan kamu..." required><?= e($_POST['pesan'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Kirim Pesan →</button>
                    </form>
                </div>
            </div>
        </section>
        <section class="location-section">
            <div class="location-content">
                <div>
                    <span>LOKASI</span>
                    <h2>Temukan<br>Pesantren Mafatih.</h2>
                </div>
                <div class="location-box">
                    <div class="map-placeholder">
                        <div class="map-circle">M</div>
                        <div class="map-pin">●</div>
                        <p>Wanayasa, Purwakarta</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
    