<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$id = is_array($input) ? (int) ($input['id'] ?? 0) : (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    respond_json(['success' => false, 'message' => 'Invalid work id.'], 400);
}

$pdo = get_pdo();
$stmt = $pdo->prepare('SELECT is_published FROM works WHERE id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    respond_json(['success' => false, 'message' => 'Not found.'], 404);
}

$newStatus = (int) $row['is_published'] === 1 ? 0 : 1;
$pdo->prepare('UPDATE works SET is_published = ? WHERE id = ?')->execute([$newStatus, $id]);

respond_json(['success' => true, 'is_published' => $newStatus]);
