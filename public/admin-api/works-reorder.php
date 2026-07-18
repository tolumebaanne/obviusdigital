<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$order = is_array($input) ? ($input['order'] ?? null) : null;

if (!is_array($order) || empty($order)) {
    respond_json(['success' => false, 'message' => 'Invalid order payload.'], 400);
}

$pdo = get_pdo();
$stmt = $pdo->prepare('UPDATE works SET sort_order = ? WHERE id = ?');
foreach ($order as $index => $workId) {
    $stmt->execute([$index, (int) $workId]);
}

respond_json(['success' => true]);
