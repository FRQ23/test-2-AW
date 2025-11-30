<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

// Solo administradores pueden actualizar usuarios
require_admin('../index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../admin/index.php');
}

$id = (int)($_POST['id'] ?? 0);
$fullName = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$isAdmin = isset($_POST['is_admin']) ? 1 : 0;
$acceptedTerms = isset($_POST['accepted_terms']) ? 1 : 0;

set_old('user_edit', [
    'id' => $id,
    'full_name' => $fullName,
    'email' => $email,
    'is_admin' => $isAdmin,
    'accepted_terms' => $acceptedTerms,
]);

if ($id <= 0) {
    flash('users', 'error', 'ID de usuario no válido.');
    redirect('../admin/index.php');
}

$errors = [];

if ($fullName === '' || strlen($fullName) < 3) {
    $errors[] = 'El nombre debe tener al menos 3 caracteres.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ingresa un correo válido.';
}

if ($errors) {
    flash('users', 'error', implode(' ', $errors));
    redirect("../admin/user_edit.php?id={$id}");
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'UPDATE users
         SET full_name = :full_name,
             email = :email,
             is_admin = :is_admin,
             accepted_terms = :accepted_terms
         WHERE id = :id'
    );
    $stmt->execute([
        ':full_name' => $fullName,
        ':email' => $email,
        ':is_admin' => $isAdmin,
        ':accepted_terms' => $acceptedTerms,
        ':id' => $id,
    ]);
} catch (PDOException $e) {
    $message = str_contains($e->getMessage(), 'Integrity constraint violation')
        ? 'Ese correo ya se encuentra registrado.'
        : 'No pudimos actualizar al usuario.';
    flash('users', 'error', $message);
    redirect("../admin/user_edit.php?id={$id}");
}

clear_old('user_edit');
flash('users', 'success', 'Usuario actualizado correctamente.');
redirect('../admin/index.php');

