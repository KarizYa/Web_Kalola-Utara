<?php
// Simple admin creation script. Run once then delete this file.
require __DIR__ . '/db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $msg = 'Username dan kata sandi wajib diisi.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM admins WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $exists = $stmt->fetch();

        if ($exists) {
            $msg = 'Username sudah ada. Pilih username lain atau hapus user terlebih dahulu.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)');
            if ($ins->execute([$username, $hash])) {
                $msg = 'Akun admin berhasil dibuat. Silakan hapus file setup_admin.php untuk keamanan.';
            } else {
                $msg = 'Gagal membuat akun. Periksa koneksi DB dan struktur tabel.';
            }
        }
    }
}

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Setup Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>body{background:#f8f9fa}</style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-3">Buat Akun Admin</h5>
          <?php if ($msg): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Kata Sandi</label>
              <input name="password" type="password" class="form-control" required>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary" type="submit">Buat Admin</button>
              <a class="btn btn-outline-secondary" href="login.php">Kembali ke Login</a>
            </div>
          </form>
          <hr>
      </div>
    </div>
  </div>
</div>
</body>
</html>
