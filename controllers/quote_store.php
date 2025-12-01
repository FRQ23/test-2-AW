<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../catalogo.php#quote');
}

require_login('../login.php');

$user = current_user();
if (!$user) {
    flash('quote', 'error', 'Vuelve a iniciar sesión para enviar tu solicitud.');
    redirect('../login.php');
}

$data = [
    'phone' => trim($_POST['phone'] ?? ''),
    'bonsai_type' => trim($_POST['bonsaiType'] ?? ''),
    'size' => trim($_POST['size'] ?? ''),
    'budget' => trim($_POST['budget'] ?? ''),
    'message' => trim($_POST['message'] ?? ''),
];

$errors = [];

if ($data['bonsai_type'] === '') {
    $errors[] = 'Selecciona un tipo de bonsái.';
}

if ($data['size'] === '') {
    $errors[] = 'Selecciona un tamaño preferido.';
}

set_old('quote', $_POST);

if ($errors) {
    flash('quote', 'error', implode(' ', $errors));
    redirect('../catalogo.php#quote');
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO quotes (user_id, full_name, email, phone, bonsai_type, size, budget, message)
         VALUES (:user_id, :full_name, :email, :phone, :bonsai_type, :size, :budget, :message)'
    );
    $stmt->execute([
        ':user_id' => $user['id'],
        ':full_name' => $user['full_name'],
        ':email' => $user['email'],
        ':phone' => $data['phone'],
        ':bonsai_type' => $data['bonsai_type'],
        ':size' => $data['size'],
        ':budget' => $data['budget'],
        ':message' => $data['message'],
    ]);
} catch (PDOException $e) {
    flash('quote', 'error', 'No pudimos guardar tu solicitud. Intenta de nuevo.');
    redirect('../catalogo.php#quote');
}

clear_old('quote');
flash('quote', 'success', 'Tu solicitud fue enviada correctamente. Te responderemos en menos de 24 horas.');
redirect('../catalogo.php#quote');

