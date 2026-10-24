<?php
require_once __DIR__ . '/layout.php';
admin_boot();

$GROUPS = [
    'Umum' => [
        'nama_pesantran' => 'Nama pesantren',
        'marquee_teks' => 'Teks berjalan (marquee)',
        'alamat' => 'Alamat',
    ],
    'Beranda' => [
        'beranda_label' => 'Label kecil hero',
        'beranda_judul' => 'Judul hero',
        'beranda_teks' => 'Paragraf hero',
        'beranda_tentang_1' => 'Tentang — paragraf 1',
        'beranda_tentang_2' => 'Tentang — paragraf 2',
        'beranda_visi' => 'Ringkasan visi',
        'beranda_misi' => 'Ringkasan misi',
    ],
    'Pendaftaran' => [
        'pendaftaran_judul' => 'Judul halaman PPDB',
        'pendaftaran_teks' => 'Deskripsi halaman PPDB',
    ],
    'Kontak' => [
        'wa_number' => 'Nomor WhatsApp admin (contoh: 628123456789)',
        'email' => 'Email resmi pesantren',
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $st = db()->prepare('INSERT INTO pengaturan (kunci, nilai) VALUES (?, ?)
        ON DUPLICATE KEY UPDATE nilai = VALUES(nilai)');
    foreach ($GROUPS as $fields) {
        foreach (array_keys($fields) as $k) {
            if (isset($_POST[$k])) {
                $st->execute([$k, trim((string) $_POST[$k])]);
            }
        }
    }
    $pass = (string) ($_POST['password_baru'] ?? '');
    if ($pass !== '') {
        if (mb_strlen($pass) < 8) {
            flash_set('Password baru minimal 8 karakter.', 'error');
            header('Location: pengaturan.php');
            exit;
        }
        $st->execute(['admin_password', password_hash($pass, PASSWORD_DEFAULT)]);
        flash_set('Pengaturan & password berhasil disimpan.', 'success');
    } else {
        flash_set('Pengaturan berhasil disimpan.', 'success');
    }
    header('Location: pengaturan.php');
    exit;
}

admin_header('Pengaturan Situs', 'pengaturan');
?>
<form class="form wide" method="post">
  <?= csrf_field() ?>
  <?php foreach ($GROUPS as $group => $fields): ?>
  <fieldset>
    <legend><?= e($group) ?></legend>
    <?php foreach ($fields as $kunci => $label): ?>
    <label><?= e($label) ?>
      <textarea name="<?= e($kunci) ?>" rows="2"><?= e(pengaturan($kunci)) ?></textarea>
    </label>
    <?php endforeach; ?>
  </fieldset>
  <?php endforeach; ?>
  <fieldset>
    <legend>Akun Admin</legend>
    <label>Password baru (kosongkan jika tidak berubah)
      <input type="password" name="password_baru" autocomplete="new-password">
    </label>
    <p class="muted">Username saat ini: <b><?= e(pengaturan('admin_user', 'admin')) ?></b>. Ubah lewat tabel <code>pengaturan</code> bila perlu.</p>
  </fieldset>
  <div class="form-actions">
    <button type="submit" class="btn save">Simpan Semua</button>
  </div>
</form>
<?php admin_footer(); ?>
