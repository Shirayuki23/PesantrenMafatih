<?php
$active = 'kalender';
$page_title = 'Kalender Akademik - Pesantren Mafatih Wanayasa';
$page_css = 'Kalender.css';
require __DIR__ . '/includes/header.php';
$crumbs = [['label' => 'Kalender Akademik']];

$events = db()->query('SELECT id, judul, kategori, deskripsi, tanggal_mulai, tanggal_selesai
                       FROM kalender_akademik
                       ORDER BY tanggal_mulai, urutan')->fetchAll();

$today = date('Y-m-d');
foreach ($events as &$ev) {
    $end = $ev['tanggal_selesai'] ?: $ev['tanggal_mulai'];
    if ($ev['tanggal_mulai'] > $today) {
        $ev['status'] = 'dekat';
    } elseif ($end >= $today) {
        $ev['status'] = 'berlangsung';
    } else {
        $ev['status'] = 'lewat';
    }
}
unset($ev);

$dekat = array_values(array_filter($events, fn ($e) => $e['status'] !== 'lewat'));
$dekat = array_slice($dekat, 0, 3);

$bln = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$blnPendek = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

function rentang_tgl(string $mulai, ?string $selesai, array $blnPendek): string
{
    $m = strtotime($mulai);
    $s = $selesai ? strtotime($selesai) : null;
    $label = (int) date('j', $m) . ' ' . $blnPendek[(int) date('n', $m) - 1];
    if ($s && $s !== $m) {
        $label .= ' – ' . (int) date('j', $s) . ' ' . $blnPendek[(int) date('n', $s) - 1] . ' ' . date('Y', $s);
        if (date('nY', $m) === date('nY', $s)) {
            $label = (int) date('j', $m) . '–' . (int) date('j', $s) . ' ' . $blnPendek[(int) date('n', $m) - 1] . ' ' . date('Y', $m);
        }
    } else {
        $label .= ' ' . date('Y', $m);
    }
    return $label;
}

$grup = [];
foreach ($events as $ev) {
    $key = date('n-Y', strtotime($ev['tanggal_mulai']));
    $grup[$key][] = $ev;
}

$statusLabel = ['dekat' => 'Akan datang', 'berlangsung' => 'Sedang berlangsung', 'lewat' => 'Selesai'];
$kats = array_values(array_unique(array_column($events, 'kategori')));
?>
    <main>
        <section class="page-header">
            <div class="header-content">
                <span>AGENDA PESANTREN</span>
                <h1>Kalender Akademik</h1>
                <p>
                    Jadwal resmi kegiatan pembelajaran, ujian, libur, dan agenda
                    Pesantren Mafatih Wanayasa sepanjang tahun ajaran.
                </p>
            </div>
        </section>
        <?= crumbs_html($crumbs) ?>

        <?php if ($dekat): ?>
        <section class="content kal-next">
            <div class="section-title"><span>TERDEKAT</span><h2>Agenda Bulan Ini &amp; Berikutnya</h2></div>
            <div class="kal-next-grid">
                <?php foreach ($dekat as $ev): ?>
                <a class="kal-next-card reveal" href="#kal-<?= (int) $ev['id'] ?>">
                    <span class="kal-status st-<?= e($ev['status']) ?>"><?= e($statusLabel[$ev['status']]) ?></span>
                    <small><?= e($ev['kategori']) ?> · <?= e(rentang_tgl($ev['tanggal_mulai'], $ev['tanggal_selesai'], $blnPendek)) ?></small>
                    <h3><?= e($ev['judul']) ?></h3>
                    <p><?= e($ev['deskripsi']) ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <section class="content kal-wrap">
            <div class="section-title"><span>JADWAL LENGKAP</span><h2>Seluruh Agenda Tahun Ajaran</h2></div>
            <?php if (count($kats) > 1): ?>
            <div class="chip-row" data-filter-group=".kal-item">
                <button class="chip active" data-cat="">Semua</button>
                <?php foreach ($kats as $k): ?>
                <button class="chip" data-cat="<?= e($k) ?>"><?= e($k) ?></button>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php foreach ($grup as $key => $items): $ts = strtotime($items[0]['tanggal_mulai']); ?>
            <div class="kal-month">
                <h3 class="kal-month-label"><i></i><?= e($bln[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts)) ?></h3>
                <div class="kal-list">
                    <?php foreach ($items as $ev): $m = strtotime($ev['tanggal_mulai']); ?>
                    <article class="kal-item reveal<?= $ev['status'] === 'lewat' ? ' kal-lewat' : '' ?>"
                             id="kal-<?= (int) $ev['id'] ?>" data-cat="<?= e($ev['kategori']) ?>">
                        <div class="kal-date">
                            <b><?= (int) date('j', $m) ?></b>
                            <span><?= e($blnPendek[(int) date('n', $m) - 1]) ?></span>
                        </div>
                        <div class="kal-body">
                            <div class="kal-meta">
                                <span class="kal-kat"><?= e($ev['kategori']) ?></span>
                                <span class="kal-status st-<?= e($ev['status']) ?>"><?= e($statusLabel[$ev['status']]) ?></span>
                            </div>
                            <h4><?= e($ev['judul']) ?></h4>
                            <p><?= e($ev['deskripsi']) ?></p>
                            <small class="kal-range">
                                <i class="fa-regular fa-calendar"></i>
                                <?= e(rentang_tgl($ev['tanggal_mulai'], $ev['tanggal_selesai'], $blnPendek)) ?>
                            </small>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (!$events): ?>
            <p class="muted">Belum ada agenda yang dipublikasikan.</p>
            <?php endif; ?>

            <div class="kal-cta reveal">
                <h3>Bagian dari kalender ini?</h3>
                <p>Daftarkan santri Anda dan ikuti tahun ajaran bersama Pesantren Mafatih.</p>
                <a class="btn primary" href="pendaftaran.php">Daftar Sekarang</a>
            </div>
        </section>
    </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
