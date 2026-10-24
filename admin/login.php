<?php
require_once __DIR__ . '/../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim((string) ($_POST['username'] ?? ''));
    $pass = (string) ($_POST['password'] ?? '');
    $okUser = hash_equals(pengaturan('admin_user', 'admin'), $user);
    $okPass = password_verify($pass, pengaturan('admin_password', ''));
    if ($okUser && $okPass) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $user;
        header('Location: index.php');
        exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — Pesantren Mafatih</title>
  <link rel="stylesheet" href="../assets/css/admin.css?<?= ver('assets/css/admin.css') ?>">
</head>
<body class="login-body">
  <form class="login-card" method="post" action="login.php">
    <img class="login-logo" src="../assets/img/logo-mafatih.png" alt="Logo Pesantren Mafatih">
    <h1>Admin Mafatih</h1>
    <p class="sub">Panel pengelolaan konten website pesantren.</p>
    <?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>
    <label>Username
      <input type="text" name="username" required autofocus>
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <button type="submit">Masuk</button>
    <a class="back" href="../index.php">← Kembali ke website</a>
  </form>
</body>
</html>
