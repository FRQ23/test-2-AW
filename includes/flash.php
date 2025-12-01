<?php
declare(strict_types=1);

function flash(string $context, string $status, string $message): void
{
    $_SESSION['flash'][$context][] = [
        'status' => $status,
        'message' => $message,
    ];
}

function flash_consume(string $context): array
{
    $messages = $_SESSION['flash'][$context] ?? [];
    unset($_SESSION['flash'][$context]);
    return $messages;
}

function flash_consume_all(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

