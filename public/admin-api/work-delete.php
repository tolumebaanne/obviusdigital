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

$stmt = $pdo->prepare('SELECT image_path FROM work_images WHERE work_id = ?');
$stmt->execute([$id]);
foreach ($stmt->fetchAll() as $image) {
    $absPath = __DIR__ . '/../uploads/work/' . basename($image['image_path']);
    if (is_file($absPath)) {
        unlink($absPath);
    }
}

// work_images rows cascade-delete via the FK constraint
$pdo->prepare('DELETE FROM works WHERE id = ?')->execute([$id]);

respond_json(['success' => true]);
