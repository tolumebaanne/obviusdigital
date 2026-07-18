<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$pdo = get_pdo();
$logs = $pdo->query('SELECT email, ip_address, logged_in_at FROM login_log ORDER BY id DESC LIMIT 20')->fetchAll();

respond_json(['success' => true, 'logs' => $logs]);
