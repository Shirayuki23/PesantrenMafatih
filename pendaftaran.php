<?php
require __DIR__ . '/config/database.php';

$active = 'pendaftaran';
$page_title = 'Pendaftaran Santri Baru - Pesantren Mafatih Wanayasa';
$page_css = 'Pendaftaran.css';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $in = array_map(fn ($v) => trim((string) $v), $_POST);
    $nama = $in['nama_santri'] ?? '';
    $tempat = $in['tempat_lahir'] ?? '';
    $tglLahir = $in['tanggal_lahir'] ?? '';
    $jk = $in['jenis_kelamin'] ?? '';
    $sekolah = $in['asal_sekolah'] ?? '';
    $wali = $in['nama_wali'] ?? '';
    $telp = $in['telepon_wali'] ?? '';
    $alamat = $in['alamat'] ?? '';
    $program = $in['program_diminati'] ?? '';

    if ($nama === '') $errors[] = 'Nama santri wajib diisi.';
    if ($tempat === '') $errors[] = 'Tempat lahir wajib diisi.';
    if (!$tglLahir || !DateTime::createFromFormat('Y-m-d', $tglLahir)) $errors[] = 'Tanggal lahir tidak valid.';
    if (!in_array($jk, ['Laki-laki', 'Perempuan'], true)) $errors[] = 'Jenis kelamin wajib dipilih.';
    if ($sekolah === '') $errors[] = 'Asal sekolah wajib diisi.';
    if ($wali === '') $errors[] = 'Nama wali wajib diisi.';
    if ($telp === '' || !preg_match('/^[0-9+\-\s()]{7,20}$/', $telp)) $errors[] = 'Nomor telepon wali tidak valid.';
    if ($alamat === '') $errors[] = 'Alamat wajib diisi.';

    if (!$errors) {
        $st = db()->prepare('INSERT INTO pendaftaran
            (nama_santri, tempat_lahir, tanggal_lahir, jenis_kelamin, asal_sekolah, nama_wali, telepon_wali, alamat, program_diminati)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $st->execute([$nama, $tempat, $tglLahir, $jk, $sekolah, $wali, $telp, $alamat, $program]);
        flash_set('Pendaftaran berhasil dikirim. Tim administrasi akan menghubungi wali santri.', 'success');
        header('Location: pendaftaran.php');
        exit;
    }
}

$programs = db()->query('SELECT judul FROM program ORDER BY urutan')->fetchAll(PDO::FETCH_COLUMN);
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Pendaftaran Santri Baru']];
$val = fn (string $k): string => e($_POST[$k] ?? '');
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>PPDB <?= e(date('Y')) ?></span>
                <h1><?= e(pengaturan('pendaftaran_judul', 'Pendaftaran Santri Baru')) ?></h1>
                <p><?= e(pengaturan('pendaftaran_teks')) ?></p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>

        <section class="content ppdb-wrap">
            <div class="alur-box reveal">
                <div class="section-title">
                    <span>ALUR PENDAFTARAN</span>
                    <h2>4 Langkah Mudah</h2>
                </div>
                <ol class="alur">
                    <li><b>1</b><span>Isi formulir pendaftaran online ini.</span></li>
                    <li><b>2</b><span>Verifikasi data oleh administrasi pesantren.</span></li>
                    <li><b>3</b><span>Wawancara & survey bersama calon santri dan wali.</span></li>
                    <li><b>4</b><span>Pengumuman dan daftar ulang.</span></li>
                </ol>
            </div>

            <div class="ppdb-form-box reveal">
                <div class="form-heading">
                    <span>FORMULIR ONLINE</span>
                    <h2>Data Calon Santri</h2>
                </div>
                <?php if ($errors): ?>
                <ul class="form-errors">
                    <?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <form method="post" action="pendaftaran.php" class="ppdb-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_santri">Nama Lengkap Santri</label>
                            <input type="text" id="nama_santri" name="nama_santri" required value="<?= $val('nama_santri') ?>">
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" required value="<?= $val('tempat_lahir') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required value="<?= $val('tanggal_lahir') ?>">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">-- Pilih --</option>
                                <option <?= ($_POST['jenis_kelamin'] ?? '') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option <?= ($_POST['jenis_kelamin'] ?? '') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="asal_sekolah">Asal Sekolah</label>
                            <input type="text" id="asal_sekolah" name="asal_sekolah" required value="<?= $val('asal_sekolah') ?>">
                        </div>
                        <div class="form-group">
                            <label for="program_diminati">Program Diminati</label>
                            <select id="program_diminati" name="program_diminati">
                                <option value="">Belum menentukan</option>
                                <?php foreach ($programs as $p): ?>
                                <option <?= ($_POST['program_diminati'] ?? '') === $p ? 'selected' : '' ?>><?= e($p) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_wali">Nama Wali</label>
                            <input type="text" id="nama_wali" name="nama_wali" required value="<?= $val('nama_wali') ?>">
                        </div>
                        <div class="form-group">
                            <label for="telepon_wali">Telepon/WhatsApp Wali</label>
                            <input type="tel" id="telepon_wali" name="telepon_wali" required placeholder="08xxxxxxxxxx" value="<?= $val('telepon_wali') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="4" required><?= $val('alamat') ?></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Kirim Pendaftaran →</button>
                </form>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
