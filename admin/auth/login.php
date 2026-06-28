<?php
session_start();
if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: ../dashboard.php');
    exit;
}
$error_code = $_GET['error'] ?? '';
$error_msg = '';
if ($error_code === 'empty')   $error_msg = 'Username dan kata sandi wajib diisi.';
if ($error_code === 'invalid') $error_msg = 'Username atau kata sandi salah.';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — Pesona Kolaka Utara</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent: #10b981;
            --accent-hover: #059669;
            --dark: #0f172a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background blobs */
        body::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(16,185,129,.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -200px; left: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        /* Brand */
        .login-brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-brand-icon {
            width: 64px; height: 64px;
            background: var(--accent);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 1.8rem;
            color: #fff;
            box-shadow: 0 8px 24px rgba(16,185,129,.35);
        }

        .login-brand h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
            letter-spacing: .5px;
        }

        .login-brand p {
            font-size: .85rem;
            color: #64748b;
            margin: 0;
        }

        /* Card */
        .login-card {
            background: #1e293b;
            border-radius: 20px;
            padding: 36px 32px;
            border: 1px solid rgba(255,255,255,.07);
            box-shadow: 0 25px 50px rgba(0,0,0,.4);
        }

        .login-card h2 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 24px;
        }

        /* Form */
        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 8px;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: .9rem;
        }

        .form-control {
            width: 100%;
            background: #0f172a;
            border: 1.5px solid #334155;
            border-radius: 12px;
            padding: 12px 14px 12px 42px;
            color: #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem;
            transition: .25s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(16,185,129,.15);
            background: #0f172a;
            color: #e2e8f0;
        }

        .form-control::placeholder { color: #475569; }

        /* Error alert */
        .alert-error {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.3);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fca5a5;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-size: .95rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: .25s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(16,185,129,.35);
        }

        .btn-login:active { transform: translateY(0); }

        /* Footer note */
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: .78rem;
            color: #475569;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- Brand -->
    <div class="login-brand">
         <div>
         <img src="../../image/logo.png" alt="Logo Kolaka Utara" class="brand-logo" style="width: 70px; height: 70px; object-fit: cover;">
      </div>
        <h1>PESONA KOLAKA UTARA</h1>
    </div>

    <!-- Card -->
    <div class="login-card">
        <h2><i class="fas fa-lock me-2" style="color:#10b981;"></i>Masuk sebagai Admin</h2>

        <?php if ($error_msg): ?>
            <div class="alert-error">
                <i class="fas fa-circle-exclamation"></i>
                <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php endif; ?>

        <form action="auth.php" method="post">

            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input name="username" type="text" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input name="password" type="password" class="form-control" placeholder="Masukkan kata sandi" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-right-to-bracket me-2"></i>
                Masuk
            </button>

        </form>
    </div>

    <div class="login-footer">
        &copy; <?= date('Y') ?> Pesona Kolaka Utara. All rights reserved.
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
