<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);
$imageId = is_array($input) ? (int) ($input['image_id'] ?? 0) : (int) ($_POST['image_id'] ?? 0);

if ($imageId <= 0) {
    respond_json(['success' => false, 'message' => 'Invalid image id.'], 400);
}

$pdo = get_pdo();
$stmt = $pdo->prepare('SELECT image_path FROM work_images WHERE id = ?');
$stmt->execute([$imageId]);
$image = $stmt->fetch();

if (!$image) {
    respond_json(['success' => false, 'message' => 'Image not found.'], 404);
}

$absPath = __DIR__ . '/../uploads/work/' . basename($image['image_path']);
if (is_file($absPath)) {
    unlink($absPath);
}
$pdo->prepare('DELETE FROM work_images WHERE id = ?')->execute([$imageId]);

respond_json(['success' => true]);
