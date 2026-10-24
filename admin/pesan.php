<?php
require_once __DIR__ . '/layout.php';
admin_boot();

$t = ($_GET['t'] ?? 'pesan') === 'pendaftaran' ? 'pendaftaran' : 'pesan';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int) ($_POST['id'] ?? 0);
    if (isset($_POST['delete'])) {
        if ($t === 'pesan') {
            db()->prepare('DELETE FROM pesan_kontak WHERE id = ?')->execute([$id]);
        } else {
            db()->prepare('DELETE FROM pendaftaran WHERE id = ?')->execute([$id]);
        }
        flash_set('Data dihapus.', 'success');
    } elseif (isset($_POST['status']) && $t === 'pendaftaran') {
        $status = in_array($_POST['status'], ['baru', 'diproses', 'diterima', 'ditolak'], true)
            ? $_POST['status'] : 'baru';
        db()->prepare('UPDATE pendaftaran SET status = ? WHERE id = ?')->execute([$status, $id]);
        flash_set('Status pendaftaran diperbarui.', 'success');
    }
    header('Location: pesan.php?t=' . $t);
    exit;
}

admin_header('Pesan & Pendaftaran', 'pesan');
?>
<div class="tabs">
  <a class="tab<?= $t === 'pesan' ? ' active' : '' ?>" href="pesan.php?t=pesan">Pesan Kontak</a>
  <a class="tab<?= $t === 'pendaftaran' ? ' active' : '' ?>" href="pesan.php?t=pendaftaran">Pendaftaran (PPDB)</a>
</div>

<?php if ($t === 'pesan'): ?>
<?php $rows = db()->query('SELECT * FROM pesan_kontak ORDER BY id DESC')->fetchAll(); ?>
<table class="grid">
  <thead><tr><th>Tanggal</th><th>Nama</th><th>Email</th><th>Subjek</th><th>Pesan</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><time><?= e(substr($r['created_at'], 0, 16)) ?></time></td>
      <td><?= e($r['nama']) ?></td>
      <td><?= e($r['email']) ?></td>
      <td><?= e($r['subjek']) ?></td>
      <td class="wrap"><?= e(mb_strimwidth($r['pesan'], 0, 120, '…')) ?></td>
      <td class="actions">
        <form method="post" onsubmit="return confirm('Hapus pesan ini?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
          <button type="submit" name="delete" class="del">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$rows): ?><tr><td colspan="6" class="muted">Belum ada pesan masuk.</td></tr><?php endif; ?>
  </tbody>
</table>
<?php else: ?>
<?php $rows = db()->query('SELECT * FROM pendaftaran ORDER BY id DESC')->fetchAll(); ?>
<table class="grid">
  <thead><tr><th>Tanggal</th><th>Santri</th><th>L/P</th><th>Asal Sekolah</th><th>Wali</th><th>Telepon</th><th>Program</th><th>Status</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><time><?= e(substr($r['created_at'], 0, 10)) ?></time></td>
      <td><strong><?= e($r['nama_santri']) ?></strong><br><small><?= e($r['tempat_lahir'] . ', ' . tgl_id($r['tanggal_lahir'])) ?></small></td>
      <td><?= e(mb_substr($r['jenis_kelamin'], 0, 1)) ?></td>
      <td><?= e($r['asal_sekolah']) ?></td>
      <td><?= e($r['nama_wali']) ?></td>
      <td><?= e($r['telepon_wali']) ?></td>
      <td><?= e($r['program_diminati']) ?></td>
      <td>
        <form method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
          <select name="status" onchange="this.form.submit()">
            <?php foreach (['baru', 'diproses', 'diterima', 'ditolak'] as $s): ?>
            <option <?= $r['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
            <?php endforeach; ?>
          </select>
        </form>
      </td>
      <td class="actions">
        <form method="post" onsubmit="return confirm('Hapus pendaftar ini?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
          <button type="submit" name="delete" class="del">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$rows): ?><tr><td colspan="9" class="muted">Belum ada pendaftar.</td></tr><?php endif; ?>
  </tbody>
</table>
<?php endif; ?>
<?php admin_footer(); ?>
