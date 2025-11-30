<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

// Solo administradores pueden responder cotizaciones
require_admin('../admin/index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../admin/index.php');
}

$quoteId = (int)($_POST['quote_id'] ?? 0);
$response = trim($_POST['response_message'] ?? '');

if ($quoteId <= 0 || $response === '') {
    flash('users', 'error', 'Selecciona una solicitud y escribe una respuesta.');
    redirect('../admin/index.php');
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare(
        'UPDATE quotes
         SET response_message = :response,
             response_sent_at = NOW()
         WHERE id = :id'
    );
    $stmt->execute([
        ':response' => $response,
        ':id' => $quoteId,
    ]);
} catch (PDOException $e) {
    flash('users', 'error', 'No pudimos guardar la respuesta. Intenta nuevamente.');
    redirect('../admin/index.php');
}

flash('users', 'success', 'Respuesta guardada. No olvides contactar al cliente por correo.');
redirect('../admin/index.php');

