<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

// Solo administradores pueden eliminar usuarios
require_admin('../index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../admin/index.php');
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    flash('users', 'error', 'ID de usuario no válido.');
    redirect('../admin/index.php');
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
} catch (PDOException $e) {
    flash('users', 'error', 'No pudimos eliminar al usuario.');
    redirect('../admin/index.php');
}

flash('users', 'success', 'Usuario eliminado correctamente.');
redirect('../admin/index.php');

