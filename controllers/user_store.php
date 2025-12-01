<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../register.php');
}

$data = [
    'full_name' => trim($_POST['regFullName'] ?? ''),
    'email' => trim($_POST['regEmail'] ?? ''),
    'password' => $_POST['regPassword'] ?? '',
    'confirm_password' => $_POST['regConfirmPassword'] ?? '',
    'accepted_terms' => isset($_POST['regTerms']) ? 1 : 0,
];

set_old('register', [
    'regFullName' => $data['full_name'],
    'regEmail' => $data['email'],
    'regTerms' => $data['accepted_terms'],
]);

$errors = [];

if ($data['full_name'] === '' || strlen($data['full_name']) < 3) {
    $errors[] = 'El nombre debe tener al menos 3 caracteres.';
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ingresa un correo válido.';
}

// Validación de contraseña segura (lado del servidor)
if (strlen($data['password']) < 8) {
    $errors[] = 'La contraseña debe tener mínimo 8 caracteres.';
} elseif (!preg_match('/[A-Z]/', $data['password'])) {
    $errors[] = 'La contraseña debe contener al menos una letra MAYÚSCULA.';
} elseif (!preg_match('/[a-z]/', $data['password'])) {
    $errors[] = 'La contraseña debe contener al menos una letra minúscula.';
} elseif (!preg_match('/[0-9]/', $data['password'])) {
    $errors[] = 'La contraseña debe contener al menos un número.';
} elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>_\-]/', $data['password'])) {
    $errors[] = 'La contraseña debe contener al menos un carácter especial (!@#$%^&*).';
}

if ($data['password'] !== $data['confirm_password']) {
    $errors[] = 'Las contraseñas deben coincidir.';
}

if (!$data['accepted_terms']) {
    $errors[] = 'Debes aceptar los términos y condiciones.';
}

if ($errors) {
    flash('register', 'error', implode(' ', $errors));
    redirect('../register.php');
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO users (full_name, email, password_hash, accepted_terms)
         VALUES (:full_name, :email, :password_hash, :accepted_terms)'
    );
    $stmt->execute([
        ':full_name' => $data['full_name'],
        ':email' => $data['email'],
        ':password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
        ':accepted_terms' => $data['accepted_terms'],
    ]);

} catch (PDOException $e) {
    $message = str_contains($e->getMessage(), 'Integrity constraint violation')
        ? 'Ese correo ya se encuentra registrado.'
        : 'No pudimos completar tu registro.';
    flash('register', 'error', $message);
    redirect('../register.php');
}

clear_old('register');
flash('auth', 'success', '¡Registro exitoso! Ahora puedes iniciar sesión con tu cuenta.');
redirect('../login.php');

