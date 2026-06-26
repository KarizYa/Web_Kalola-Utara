<?php
session_start();
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: ../dashboard.php');
    exit;
}
$error_code = $_GET['error'] ?? '';
$error_msg = '';
if ($error_code === 'empty') $error_msg = 'Username dan kata sandi wajib diisi.';
if ($error_code === 'invalid') $error_msg = 'Username atau kata sandi salah.';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f8f9fa; }
        .login-card { max-width:420px; margin-top:8vh; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="card login-card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">Admin Login</h4>
            <?php if ($error_msg): ?>
                <div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($error_msg); ?></div>
            <?php endif; ?>

            <form action="auth.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <input name="password" type="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
