<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

// Solo administradores pueden editar usuarios
require_admin('../index.php');

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    flash('users', 'error', 'ID de usuario no válido.');
    redirect('index.php');
}

try {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT id, full_name, email, is_admin, accepted_terms FROM users WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    flash('users', 'error', 'No pudimos conectar con la base de datos.');
    redirect('index.php');
}

if (!$user) {
    flash('users', 'error', 'Usuario no encontrado.');
    redirect('index.php');
}

$oldData = $_SESSION['old']['user_edit'] ?? [];

$fullNameValue = $oldData['full_name'] ?? $user['full_name'];
$emailValue = $oldData['email'] ?? $user['email'];
$isAdminValue = isset($oldData['is_admin']) ? (int)$oldData['is_admin'] : (int)$user['is_admin'];
$acceptedValue = isset($oldData['accepted_terms']) ? (int)$oldData['accepted_terms'] : (int)$user['accepted_terms'];

$messages = flash_consume('users');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario | Bons-AI</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <div class="container admin-header__content">
            <div>
                <h1>Editar usuario</h1>
                <p>Actualiza la información almacenada en la base de datos.</p>
            </div>
            <div class="admin-header__actions">
                <a class="admin-button" href="index.php">← Volver al listado</a>
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

        <section class="admin-card">
            <form action="../controllers/user_update.php" method="POST" class="admin-form">
                <input type="hidden" name="id" value="<?= (int)$user['id']; ?>">
                <div class="admin-form__group">
                    <label for="full_name">Nombre completo *</label>
                    <input type="text" id="full_name" name="full_name" value="<?= sanitize($fullNameValue); ?>" required minlength="3">
                </div>
                <div class="admin-form__group">
                    <label for="email">Correo *</label>
                    <input type="email" id="email" name="email" value="<?= sanitize($emailValue); ?>" required>
                </div>
                <div class="admin-form__group admin-form__group--checkbox">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_admin" value="1" <?= $isAdminValue ? 'checked' : ''; ?>>
                        <span>Es administrador</span>
                    </label>
                </div>
                <div class="admin-form__group admin-form__group--checkbox">
                    <label class="form-checkbox">
                        <input type="checkbox" name="accepted_terms" value="1" <?= $acceptedValue ? 'checked' : ''; ?>>
                        <span>Aceptó términos y condiciones</span>
                    </label>
                </div>
                <div class="admin-form__actions">
                    <button type="submit" class="admin-button">Guardar cambios</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

