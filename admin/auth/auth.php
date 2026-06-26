<?php
session_start();
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header('Location: login.php?error=empty');
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id, username, password FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
} catch (Exception $e) {
    // Query error
    header('Location: login.php?error=invalid');
    exit;
}

if (!$user) {
    header('Location: login.php?error=invalid');
    exit;
}

if (!password_verify($password, $user['password'])) {
    header('Location: login.php?error=invalid');
    exit;
}

session_regenerate_id(true);
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_user'] = $user['username'];

header('Location: ../dashboard.php');
exit;
