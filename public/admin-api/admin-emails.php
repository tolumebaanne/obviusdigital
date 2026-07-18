<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

// Any authenticated user can view the access list — only admins can add to it.
require_auth();

$pdo = get_pdo();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $emails = $pdo->query('SELECT id, email, is_admin FROM admin_emails ORDER BY is_admin DESC, id ASC')->fetchAll();
    respond_json(['success' => true, 'emails' => $emails]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_super_admin();

    $input = json_decode(file_get_contents('php://input'), true);
    $email = is_array($input) ? ($input['email'] ?? '') : ($_POST['email'] ?? '');
    $email = strtolower(trim((string) $email));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond_json(['success' => false, 'message' => 'Enter a valid email address.'], 400);
    }

    try {
        // New emails are never added as admins — only an admin row can grant
        // that, and only by editing the database directly (m0t.BUILDER.4.3).
        $pdo->prepare('INSERT INTO admin_emails (email, is_admin) VALUES (?, 0)')->execute([$email]);
    } catch (PDOException $e) {
        // Unique constraint violation — this email is already authorized.
        respond_json(['success' => false, 'message' => 'That email is already on the list.'], 409);
    }

    respond_json(['success' => true]);
}

respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
