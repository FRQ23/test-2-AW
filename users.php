<?php
declare(strict_types=1);

$queryString = $_SERVER['QUERY_STRING'] ?? '';
$suffix = $queryString !== '' ? '?' . $queryString : '';

header("Location: admin/index.php{$suffix}");
exit;

