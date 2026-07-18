<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

// m0t.FLOW.3.4 — logout must be POST, never GET.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

admin_session_start();
$_SESSION = [];
session_destroy();

respond_json(['success' => true]);
