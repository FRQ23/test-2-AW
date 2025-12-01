<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

// Solo administradores pueden acceder al panel
require_admin('../index.php');

$users = [];
$quotes = [];
$dbError = false;
$errorMessage = '';

try {
    $pdo = getConnection();
    $usersStmt = $pdo->query('SELECT id, full_name, email, is_admin, accepted_terms, created_at FROM users ORDER BY created_at DESC');
    $quotesStmt = $pdo->query(
        'SELECT q.*, u.full_name AS account_name
         FROM quotes q
         LEFT JOIN users u ON u.id = q.user_id
         ORDER BY q.created_at DESC'
    );
    $users = $usersStmt->fetchAll();
    $quotes = $quotesStmt->fetchAll();
} catch (PDOException $e) {
    $dbError = true;
    $errorMessage = $e->getMessage(); // Capturar el error real
}

$messages = flash_consume('users');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bons-AI | Panel</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <div class="container admin-header__content">
            <div>
                <h1>Panel de administración</h1>
                <p>Gestiona los registros de usuarios y solicitudes de cotización guardados en MySQL.</p>
            </div>
            <div class="admin-header__actions">
                <a class="admin-button" href="../index.php">← Volver al sitio</a>
            </div>
        </div>
    </header>
    <main class="admin-main container">
        <?php if ($messages): ?>
            <div class="flash-container">
                <?php foreach ($messages as $message): ?>
                    <div class="flash-message flash-message--<?= sanitize($message['status']); ?>">
                        <?= sanitize($message['message']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($dbError): ?>
            <div class="admin-error">
                <strong>Error de Base de Datos:</strong><br>
                <?= isset($errorMessage) ? htmlspecialchars($errorMessage) : 'No fue posible conectar con la base de datos.' ?><br><br>
                <small>Revisa tus credenciales en <code>config.php</code></small>
            </div>
        <?php else: ?>
            <section class="admin-card">
                <header class="admin-card__header">
                    <div>
                        <h2>Registros de usuarios</h2>
                        <p><?= count($users); ?> registro(s) encontrados.</p>
                    </div>
                </header>
                <?php if ($users): ?>
                    <div class="table-wrapper">
                        <table class="crud-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre completo</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Términos</th>
                                    <th>Creado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= (int)$user['id']; ?></td>
                                        <td><?= sanitize($user['full_name']); ?></td>
                                        <td><?= sanitize($user['email']); ?></td>
                                        <td><?= $user['is_admin'] ? 'Admin' : 'Usuario'; ?></td>
                                        <td><?= $user['accepted_terms'] ? 'Sí' : 'No'; ?></td>
                                        <td><?= sanitize($user['created_at']); ?></td>
                                        <td class="crud-table__actions">
                                            <a class="admin-button admin-button--ghost" href="user_edit.php?id=<?= (int)$user['id']; ?>">Editar</a>
                                            <form action="../controllers/user_delete.php" method="POST" class="inline-form" onsubmit="return confirm('¿Deseas eliminar este usuario?');">
                                                <input type="hidden" name="id" value="<?= (int)$user['id']; ?>">
                                                <button type="submit" class="admin-button admin-button--danger">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Aún no hay usuarios registrados.</p>
                <?php endif; ?>
            </section>

            <section class="admin-card">
                <header class="admin-card__header">
                    <div>
                        <h2>Solicitudes de cotización</h2>
                        <p><?= count($quotes); ?> registro(s) encontrados.</p>
                    </div>
                </header>
                <?php if ($quotes): ?>
                    <div class="table-wrapper">
                        <table class="crud-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Detalle</th>
                                    <th>Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quotes as $quote): ?>
                                    <tr>
                                        <td><?= (int)$quote['id']; ?></td>
                                        <td>
                                            <strong><?= sanitize($quote['full_name']); ?></strong><br>
                                            <small><?= sanitize($quote['email']); ?></small><br>
                                            <?php if ($quote['account_name']): ?>
                                                <small>Cuenta: <?= sanitize($quote['account_name']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div><strong>Tipo:</strong> <?= sanitize($quote['bonsai_type']); ?></div>
                                            <div><strong>Tamaño:</strong> <?= sanitize($quote['size']); ?></div>
                                            <div><strong>Presupuesto:</strong> <?= $quote['budget'] ? sanitize($quote['budget']) : 'N/D'; ?></div>
                                            <div><strong>Teléfono:</strong> <?= $quote['phone'] ? sanitize($quote['phone']) : 'N/D'; ?></div>
                                            <div><strong>Mensaje:</strong> <?= nl2br(sanitize($quote['message'])); ?></div>
                                            <small>Recibido: <?= sanitize($quote['created_at']); ?></small>
                                        </td>
                                        <td>
                                            <?php if (!empty($quote['response_message'])): ?>
                                                <p><strong>Última respuesta:</strong><br><?= nl2br(sanitize($quote['response_message'])); ?></p>
                                                <small>Enviada: <?= sanitize($quote['response_sent_at']); ?></small>
                                            <?php else: ?>
                                                <form action="../controllers/quote_response.php" method="POST" class="admin-form admin-form--compact">
                                                    <input type="hidden" name="quote_id" value="<?= (int)$quote['id']; ?>">
                                                    <label>Respuesta rápida</label>
                                                    <textarea name="response_message" rows="3" required placeholder="Escribe tu mensaje para el cliente"></textarea>
                                                    <div class="admin-form__actions">
                                                        <button type="submit" class="admin-button">Guardar respuesta</button>
                                                        <a class="admin-button admin-button--ghost" href="mailto:<?= sanitize($quote['email']); ?>?subject=Respuesta%20Bons-AI" target="_blank">Abrir correo</a>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Todavía no hay solicitudes de cotización.</p>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>

