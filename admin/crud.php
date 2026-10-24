<?php
require_once __DIR__ . '/layout.php';
admin_boot();

$ENTS = [
    'berita' => [
        'table' => 'berita', 'label' => 'Berita', 'order' => 'tanggal DESC',
        'cols' => ['id' => 'ID', 'kategori' => 'Kategori', 'judul' => 'Judul', 'tanggal' => 'Tanggal'],
        'fields' => [
            'kategori' => ['label' => 'Kategori', 'type' => 'text', 'required' => true],
            'judul' => ['label' => 'Judul', 'type' => 'text', 'required' => true],
            'deskripsi' => ['label' => 'Deskripsi (ringkas)', 'type' => 'textarea', 'required' => true],
            'konten' => ['label' => 'Konten lengkap', 'type' => 'textarea', 'required' => true],
            'gambar' => ['label' => 'URL gambar (opsional)', 'type' => 'text'],
            'tanggal' => ['label' => 'Tanggal', 'type' => 'date', 'required' => true],
            'tampil_beranda' => ['label' => 'Tampil di beranda?', 'type' => 'select', 'options' => ['0' => 'Tidak', '1' => 'Ya']],
        ],
    ],
    'galeri' => [
        'table' => 'galeri', 'label' => 'Galeri', 'order' => 'urutan',
        'cols' => ['id' => 'ID', 'kategori' => 'Kategori', 'judul' => 'Judul', 'ukuran' => 'Ukuran'],
        'fields' => [
            'kategori' => ['label' => 'Kategori', 'type' => 'text', 'required' => true],
            'judul' => ['label' => 'Judul', 'type' => 'text', 'required' => true],
            'gambar' => ['label' => 'URL gambar (opsional)', 'type' => 'text'],
            'ukuran' => ['label' => 'Ukuran', 'type' => 'select', 'options' => ['normal' => 'Normal', 'besar' => 'Besar (2 kolom)']],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
    'faq' => [
        'table' => 'faq', 'label' => 'FAQ', 'order' => 'urutan',
        'cols' => ['id' => 'ID', 'pertanyaan' => 'Pertanyaan'],
        'fields' => [
            'pertanyaan' => ['label' => 'Pertanyaan', 'type' => 'text', 'required' => true],
            'jawaban' => ['label' => 'Jawaban', 'type' => 'textarea', 'required' => true],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
    'testimoni' => [
        'table' => 'testimoni', 'label' => 'Testimoni', 'order' => 'urutan',
        'cols' => ['id' => 'ID', 'nama' => 'Nama', 'asal' => 'Asal'],
        'fields' => [
            'nama' => ['label' => 'Nama', 'type' => 'text', 'required' => true],
            'asal' => ['label' => 'Asal/keterangan', 'type' => 'text', 'required' => true],
            'isi' => ['label' => 'Isi testimoni', 'type' => 'textarea', 'required' => true],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
    'program' => [
        'table' => 'program', 'label' => 'Program', 'order' => 'urutan',
        'cols' => ['id' => 'ID', 'judul' => 'Judul', 'tampil_di' => 'Tampil di'],
        'fields' => [
            'judul' => ['label' => 'Judul', 'type' => 'text', 'required' => true],
            'deskripsi' => ['label' => 'Deskripsi', 'type' => 'textarea', 'required' => true],
            'ikon' => ['label' => 'Ikon (emoji, opsional)', 'type' => 'text'],
            'tampil_di' => ['label' => 'Tampil di', 'type' => 'select',
                'options' => ['program' => 'Halaman Program', 'beranda' => 'Beranda', 'keduanya' => 'Keduanya']],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
    'kalender' => [
        'table' => 'kalender_akademik', 'label' => 'Kalender Akademik', 'order' => 'tanggal_mulai',
        'cols' => ['id' => 'ID', 'judul' => 'Judul', 'kategori' => 'Kategori',
            'tanggal_mulai' => 'Mulai', 'tanggal_selesai' => 'Selesai'],
        'fields' => [
            'judul' => ['label' => 'Nama agenda', 'type' => 'text', 'required' => true],
            'kategori' => ['label' => 'Kategori', 'type' => 'select',
                'options' => ['Pembelajaran' => 'Pembelajaran', 'Ujian' => 'Ujian', 'Libur' => 'Libur', 'Kegiatan' => 'Kegiatan']],
            'deskripsi' => ['label' => 'Deskripsi', 'type' => 'textarea', 'required' => true],
            'tanggal_mulai' => ['label' => 'Tanggal mulai', 'type' => 'date', 'required' => true],
            'tanggal_selesai' => ['label' => 'Tanggal selesai (opsional)', 'type' => 'date'],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
    'santri' => [
        'table' => 'santri', 'label' => 'Santri', 'order' => 'id DESC',
        'cols' => ['id' => 'ID', 'nama' => 'Nama', 'tingkat' => 'Tingkat', 'angkatan' => 'Angkatan', 'status' => 'Status'],
        'fields' => [
            'nama' => ['label' => 'Nama santri', 'type' => 'text', 'required' => true],
            'tingkat' => ['label' => 'Tingkat', 'type' => 'select',
                'options' => ['SD' => 'SD/MI', 'SMP' => 'SMP/MTs', 'SMA' => 'SMA/MA']],
            'angkatan' => ['label' => 'Angkatan (tahun masuk)', 'type' => 'text'],
            'status' => ['label' => 'Status', 'type' => 'select',
                'options' => ['aktif' => 'Aktif', 'pulang' => 'Pulang/Keluar sementara', 'lulus' => 'Lulus', 'keluar' => 'Keluar']],
        ],
    ],
    'prestasi' => [
        'table' => 'prestasi', 'label' => 'Prestasi', 'order' => 'tanggal DESC',
        'cols' => ['id' => 'ID', 'judul' => 'Prestasi', 'peraih' => 'Peraih', 'tingkat' => 'Tingkat', 'tanggal' => 'Tanggal'],
        'fields' => [
            'judul' => ['label' => 'Nama prestasi', 'type' => 'text', 'required' => true],
            'peraih' => ['label' => 'Peraih (nama santri/kelompok)', 'type' => 'text', 'required' => true],
            'tingkat' => ['label' => 'Tingkat', 'type' => 'select',
                'options' => ['Kabupaten' => 'Kabupaten/Kota', 'Provinsi' => 'Provinsi', 'Nasional' => 'Nasional']],
            'deskripsi' => ['label' => 'Deskripsi', 'type' => 'textarea', 'required' => true],
            'tanggal' => ['label' => 'Tanggal pencapaian', 'type' => 'date', 'required' => true],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
    'berkas' => [
        'table' => 'berkas', 'label' => 'Berkas Unduhan', 'order' => 'urutan',
        'cols' => ['id' => 'ID', 'nama' => 'Nama Berkas', 'kategori' => 'Kategori', 'ukuran' => 'Ukuran'],
        'fields' => [
            'nama' => ['label' => 'Nama berkas', 'type' => 'text', 'required' => true],
            'kategori' => ['label' => 'Kategori', 'type' => 'select',
                'options' => ['Formulir' => 'Formulir', 'Panduan' => 'Panduan', 'Surat' => 'Surat', 'Lainnya' => 'Lainnya']],
            'deskripsi' => ['label' => 'Deskripsi singkat', 'type' => 'textarea', 'required' => true],
            'url' => ['label' => 'URL/lokasi file (contoh: uploads/berkas.pdf)', 'type' => 'text', 'required' => true],
            'ukuran' => ['label' => 'Ukuran (teks, opsional)', 'type' => 'text'],
            'urutan' => ['label' => 'Urutan', 'type' => 'number'],
        ],
    ],
];

$ent = (string) ($_GET['ent'] ?? 'berita');
if (!isset($ENTS[$ent])) {
    http_response_code(404);
    die('Entitas tidak dikenal.');
}
$cfg = $ENTS[$ent];
$table = $cfg['table'];
$act = (string) ($_GET['act'] ?? 'list');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (isset($_POST['delete'])) {
        $id = (int) $_POST['id'];
        db()->prepare("DELETE FROM {$table} WHERE id = ?")->execute([$id]);
        flash_set('Data berhasil dihapus.', 'success');
        header('Location: crud.php?ent=' . urlencode($ent));
        exit;
    }
    $data = [];
    foreach ($cfg['fields'] as $col => $f) {
        if (isset($_POST[$col])) {
            $val = $f['type'] === 'number' ? (int) $_POST[$col] : trim((string) $_POST[$col]);
            if ($f['type'] === 'date' && $val === '') {
                $val = null;
            }
            $data[$col] = $val;
        }
    }
    $missing = [];
    foreach ($cfg['fields'] as $col => $f) {
        if (!empty($f['required']) && ($data[$col] ?? '') === '') {
            $missing[] = $f['label'];
        }
    }
    if ($missing) {
        flash_set('Kolom wajib belum diisi: ' . implode(', ', $missing), 'error');
    } else {
        $cols = array_keys($data);
        $set = implode(', ', array_map(fn ($c) => "{$c} = :{$c}", $cols));
        if (!empty($_POST['id'])) {
            $id = (int) $_POST['id'];
            $st = db()->prepare("UPDATE {$table} SET {$set} WHERE id = :__id");
            foreach ($data as $k => $v) {
                $st->bindValue(":{$k}", $v);
            }
            $st->bindValue(':__id', $id);
            $st->execute();
            flash_set('Data berhasil diperbarui.', 'success');
        } else {
            $st = db()->prepare("INSERT INTO {$table} (" . implode(', ', $cols) . ') VALUES ('
                . implode(', ', array_map(fn ($c) => ":{$c}", $cols)) . ')');
            foreach ($data as $k => $v) {
                $st->bindValue(":{$k}", $v);
            }
            $st->execute();
            flash_set('Data baru berhasil disimpan.', 'success');
        }
        header('Location: crud.php?ent=' . urlencode($ent));
        exit;
    }
}

$row = null;
if ($act === 'edit' && isset($_GET['id'])) {
    $st = db()->prepare("SELECT * FROM {$table} WHERE id = ?");
    $st->execute([(int) $_GET['id']]);
    $row = $st->fetch();
}
$rows = db()->query("SELECT * FROM {$table} ORDER BY {$cfg['order']}")->fetchAll();

admin_header('Kelola ' . $cfg['label'], $ent);
?>

<?php if ($act === 'edit' || $act === 'new'): ?>
<form class="form" method="post" action="crud.php?ent=<?= e($ent) ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">
  <?php foreach ($cfg['fields'] as $col => $f): ?>
    <?php $v = $row[$col] ?? ($_POST[$col] ?? ''); ?>
    <label><?= e($f['label']) ?>
      <?php if ($f['type'] === 'textarea'): ?>
      <textarea name="<?= e($col) ?>" rows="5" <?= !empty($f['required']) ? 'required' : '' ?>><?= e((string) $v) ?></textarea>
      <?php elseif ($f['type'] === 'select'): ?>
      <select name="<?= e($col) ?>">
        <?php foreach ($f['options'] as $ov => $ol): ?>
        <option value="<?= e((string) $ov) ?>" <?= (string) $v === (string) $ov ? 'selected' : '' ?>><?= e($ol) ?></option>
        <?php endforeach; ?>
      </select>
      <?php else: ?>
      <input type="<?= $f['type'] === 'number' ? 'number' : ($f['type'] === 'date' ? 'date' : 'text') ?>"
             name="<?= e($col) ?>" value="<?= e((string) $v) ?>" <?= !empty($f['required']) ? 'required' : '' ?>>
      <?php endif; ?>
    </label>
  <?php endforeach; ?>
  <div class="form-actions">
    <button type="submit" class="btn save">Simpan</button>
    <a class="btn ghost" href="crud.php?ent=<?= e($ent) ?>">Batal</a>
  </div>
</form>
<?php else: ?>
<div class="toolbar">
  <a class="btn save" href="crud.php?ent=<?= e($ent) ?>&act=new">+ Tambah <?= e($cfg['label']) ?></a>
</div>
<table class="grid">
  <thead>
    <tr>
      <?php foreach ($cfg['cols'] as $c => $cl): ?><th><?= e($cl) ?></th><?php endforeach; ?>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
    <tr>
      <?php foreach (array_keys($cfg['cols']) as $c): ?>
      <td><?= e(mb_strimwidth((string) ($r[$c] ?? ''), 0, 70, '…')) ?></td>
      <?php endforeach; ?>
      <td class="actions">
        <a href="crud.php?ent=<?= e($ent) ?>&act=edit&id=<?= (int) $r['id'] ?>">Ubah</a>
        <form method="post" action="crud.php?ent=<?= e($ent) ?>" onsubmit="return confirm('Hapus data ini?')">
          <?= csrf_field() ?>
          <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
          <button type="submit" class="del">Hapus</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="<?= count($cfg['cols']) + 1 ?>" class="muted">Belum ada data.</td></tr><?php endif; ?>
  </tbody>
</table>
<?php endif; ?>

<?php admin_footer(); ?>
