<?php
declare(strict_types=1);

// Session + auth guard for the admin API.
// m0t.FLOW.5.2 — every protected endpoint checks the session as its first action.
// m0t.AUTH.3.2 — session cookie: httpOnly, secure (prod), sameSite=Lax, 24h expiry.

require_once __DIR__ . '/db.php';

function admin_session_start(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

    session_set_cookie_params([
        'lifetime' => 60 * 60 * 24,
        'path'     => '/',
        'httponly' => true,
        'secure'   => $isHttps,
        'samesite' => 'Lax',
    ]);
    session_name('obvius_admin_session');
    session_start();
}

function require_auth(): void
{
    admin_session_start();
    if (empty($_SESSION['admin_authenticated'])) {
        respond_json(['success' => false, 'message' => 'Not authenticated.'], 401);
    }
}

function require_super_admin(): void
{
    require_auth();
    if (empty($_SESSION['is_super_admin'])) {
        respond_json(['success' => false, 'message' => 'Not authorized.'], 403);
    }
}

function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}
