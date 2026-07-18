<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

// Any authenticated user can remove a non-admin entry; removing an admin
// entry requires the caller to be an admin themselves.
require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$id = is_array($input) ? (int) ($input['id'] ?? 0) : (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    respond_json(['success' => false, 'message' => 'Invalid id.'], 400);
}

$pdo = get_pdo();

$stmt = $pdo->prepare('SELECT is_admin FROM admin_emails WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    respond_json(['success' => false, 'message' => 'Not found.'], 404);
}

if ((int) $row['is_admin'] === 1) {
    if (empty($_SESSION['is_super_admin'])) {
        respond_json(['success' => false, 'message' => 'Not authorized.'], 403);
    }
    $adminCount = (int) $pdo->query('SELECT COUNT(*) FROM admin_emails WHERE is_admin = 1')->fetchColumn();
    if ($adminCount <= 1) {
        respond_json(['success' => false, 'message' => "Can't remove the last admin."], 400);
    }
}

$pdo->prepare('DELETE FROM admin_emails WHERE id = ?')->execute([$id]);

respond_json(['success' => true]);
