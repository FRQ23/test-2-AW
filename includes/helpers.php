<?php
declare(strict_types=1);

function redirect(string $path, array $params = []): void
{
    $location = $path;
    if (!empty($params)) {
        $separator = str_contains($path, '?') ? '&' : '?';
        $location .= $separator . http_build_query($params);
    }

    header("Location: {$location}");
    exit;
}

function sanitize(?string $value, string $fallback = ''): string
{
    $raw = $value ?? $fallback;
    return htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
}

function set_old(string $context, array $data): void
{
    $_SESSION['old'][$context] = $data;
}

function old(string $context, string $field, string $default = ''): string
{
    if (!isset($_SESSION['old'][$context][$field])) {
        return $default;
    }

    return sanitize((string)$_SESSION['old'][$context][$field]);
}

function clear_old(?string $context = null): void
{
    if ($context === null) {
        unset($_SESSION['old']);
        return;
    }

    unset($_SESSION['old'][$context]);
}

