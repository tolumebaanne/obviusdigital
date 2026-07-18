<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

admin_session_start();

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$code = is_array($input) ? ($input['code'] ?? '') : ($_POST['code'] ?? '');
$code = strtoupper(trim((string) $code));
$email = is_array($input) ? ($input['email'] ?? '') : ($_POST['email'] ?? '');
$email = strtolower(trim((string) $email));

$pdo = get_pdo();

// Scoped to the submitted email — otherwise two people requesting codes
// around the same time would step on each other's most-recent-code lookup.
$stmt = $pdo->prepare('SELECT id, email, is_admin, code_hash, attempts FROM login_codes WHERE email = ? AND used = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1');
$stmt->execute([$email]);
$row = $stmt->fetch();

// Always run a hash comparison, even with no active code, to normalize response timing (m0t.AUTH.3.5)
$valid = false;
if ($row !== false && (int) $row['attempts'] < 5) {
    $valid = password_verify($code, $row['code_hash']);
} else {
    password_verify($code, '$2y$10$abcdefghijklmnopqrstuuVi0z6z5b8v2r9m0t.dummydummydu');
}

if (!$valid) {
    if ($row !== false) {
        $pdo->prepare('UPDATE login_codes SET attempts = attempts + 1 WHERE id = ?')->execute([$row['id']]);
    }
    respond_json(['success' => false, 'message' => 'Invalid or expired code.'], 401);
}

$pdo->prepare('UPDATE login_codes SET used = 1 WHERE id = ?')->execute([$row['id']]);
$pdo->prepare('INSERT INTO login_log (email, ip_address) VALUES (?, ?)')->execute([$row['email'], client_ip()]);

session_regenerate_id(true);
$_SESSION['admin_authenticated'] = true;
$_SESSION['admin_email'] = $row['email'];
$_SESSION['is_super_admin'] = (bool) $row['is_admin'];

respond_json(['success' => true]);
