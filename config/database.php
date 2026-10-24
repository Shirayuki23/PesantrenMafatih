<?php
// Konfigurasi database MySQL Pesantren Mafatih
// Environment terdeteksi otomatis dari hostname:
//   - localhost / 127.0.0.1  -> XAMPP lokal
//   - selain itu (xxx.site.je, custom domain) -> hosting InfinityFree
$_mafatih_host = strtolower($_SERVER['SERVER_NAME'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost');
$_mafatih_dev = str_contains($_mafatih_host, 'localhost')
    || str_starts_with($_mafatih_host, '127.')
    || $_mafatih_host === '[::1]'
    || !str_contains($_mafatih_host, '.');

if ($_mafatih_dev) {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'pesantren_mafatih');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    // ===== ISI DENGAN DATA DARI INFINITYFREE =====
    // Control Panel (panel.infinityfree.com) > MySQL Databases > "Manage"
    // dan cPanel > phpMyAdmin. Format contoh:
    //   MySQL Host    : sql100.infinityfree.com  (persis seperti tertulis di panel)
    //   MySQL Username: if0_12345678
    //   MySQL Database: if0_12345678_nama
    //   MySQL Password: password yang dibuat saat create database
    define('DB_HOST', 'sqlXXX.infinityfree.com');
    define('DB_NAME', 'if0XXXXXXX_pesantren_mafatih');
    define('DB_USER', 'if0XXXXXXX');
    define('DB_PASS', 'PASSWORD_MYSQL_ANDA');
}
unset($_mafatih_host, $_mafatih_dev);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . htmlspecialchars($e->getMessage())
                . ' — pastikan MySQL berjalan dan database pesantren_mafatih sudah diimport.');
        }
    }
    return $pdo;
}

function pengaturan(string $kunci, string $default = ''): string
{
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        foreach (db()->query('SELECT kunci, nilai FROM pengaturan') as $row) {
            $cache[$row['kunci']] = $row['nilai'];
        }
    }
    return $cache[$kunci] ?? $default;
}

function e(?string $str): string
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

// Versi aset berbasis waktu modifikasi file untuk cache-busting.
function ver(string $rel): string
{
    $f = __DIR__ . '/../' . $rel;
    return 'v=' . (is_file($f) ? filemtime($f) : '1');
}

function flash_set(string $msg, string $type = 'success'): void
{
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}

function flash_get(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function tgl_id(string $iso): string
{
    static $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $ts = strtotime($iso);
    if ($ts === false) {
        return $iso;
    }
    return (int) date('j', $ts) . ' ' . $bulan[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
}
