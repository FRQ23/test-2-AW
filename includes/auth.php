<?php
declare(strict_types=1);

function login_user(array $user): void
{
    $_SESSION['auth_user_id'] = (int)$user['id'];
    $_SESSION['auth_user'] = [
        'id' => (int)$user['id'],
        'full_name' => $user['full_name'],
        'email' => $user['email'],
        'is_admin' => (bool)($user['is_admin'] ?? 0),
    ];
}

function logout_user(): void
{
    unset($_SESSION['auth_user_id'], $_SESSION['auth_user']);
}

function current_user_id(): ?int
{
    return $_SESSION['auth_user_id'] ?? null;
}

function current_user(): ?array
{
    if (!isset($_SESSION['auth_user_id'])) {
        return null;
    }

    if (isset($_SESSION['auth_user'])) {
        return $_SESSION['auth_user'];
    }

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT id, full_name, email, is_admin FROM users WHERE id = :id');
        $stmt->execute([':id' => $_SESSION['auth_user_id']]);
        $user = $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }

    if ($user) {
        $_SESSION['auth_user'] = [
            'id' => (int)$user['id'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'is_admin' => (bool)$user['is_admin'],
        ];
        return $_SESSION['auth_user'];
    }

    logout_user();
    return null;
}

function require_login(string $redirectTo = '/'): void
{
    if (!current_user_id()) {
        flash('auth', 'error', 'Debes iniciar sesión para continuar.');
        redirect($redirectTo);
    }
}

function is_admin(): bool
{
    $user = current_user();
    return $user && ($user['is_admin'] ?? false);
}

function require_admin(string $redirectTo = '/'): void
{
    require_login($redirectTo);
    
    if (!is_admin()) {
        flash('auth', 'error', 'No tienes permisos para acceder a esta sección.');
        redirect($redirectTo);
    }
}

