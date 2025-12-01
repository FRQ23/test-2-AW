<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../login.php');
}

$email = trim($_POST['loginEmail'] ?? '');
$password = $_POST['loginPassword'] ?? '';

if ($email === '' || $password === '') {
    flash('auth', 'error', 'Ingresa tu correo y contraseña.');
    redirect('../login.php');
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT id, full_name, email, password_hash, is_admin FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    flash('auth', 'error', 'No pudimos verificar tus credenciales.');
    redirect('../login.php');
}

if (!$user || !password_verify($password, $user['password_hash'])) {
    flash('auth', 'error', 'Credenciales incorrectas.');
    redirect('../login.php');
}

login_user($user);
flash('auth', 'success', 'Sesión iniciada correctamente.');
redirect('../catalogo.php');

