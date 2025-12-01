<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

logout_user();
flash('auth', 'success', 'Sesión cerrada.');
redirect('../index.php');

