<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

admin_session_start();

respond_json([
    'authenticated' => !empty($_SESSION['admin_authenticated']),
    'is_super_admin' => !empty($_SESSION['is_super_admin']),
]);
