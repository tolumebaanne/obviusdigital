<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

// Server-side sanitization (m0t.BUILDER.4.2 — Trust Boundaries Must Be Enforced).
// Only well-formed <tag> sequences are stripped so nothing executable is ever
// stored — unlike strip_tags(), a lone "<" with no closing ">" (e.g. "ROI < 3x")
// is left alone instead of silently truncating the rest of the text. We do NOT
// htmlspecialchars-encode here: the front end renders this text via textContent
// (auto-escaping), so pre-encoding would show literal "&amp;" etc. to visitors.
// Any render path that uses innerHTML escapes at that point instead.
$sanitize = static function ($val): string {
    return trim((string) preg_replace('/<[^>]*>/u', '', (string) $val));
};

$id           = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$brandName    = $sanitize($_POST['brand_name'] ?? '');
$category     = $sanitize($_POST['category'] ?? '');
$description  = $sanitize($_POST['description'] ?? '');
$clientUrlRaw = trim((string) ($_POST['client_url'] ?? ''));
$clientUrl    = $clientUrlRaw !== '' ? $sanitize($clientUrlRaw) : null;

if ($brandName === '' || $category === '' || $description === '') {
    respond_json(['success' => false, 'message' => 'Brand name, category, and description are required.'], 400);
}

if ($clientUrl !== null && (!filter_var($clientUrl, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $clientUrl))) {
    respond_json(['success' => false, 'message' => 'Client URL must start with http:// or https://.'], 400);
}

$pdo = get_pdo();
$pdo->beginTransaction();

try {
    if ($id !== null) {
        $stmt = $pdo->prepare('SELECT id FROM works WHERE id = ?');
        $stmt->execute([$id]);
        if (!$stmt->fetch()) {
            throw new RuntimeException('Work not found.', 404);
        }
        $pdo->prepare('UPDATE works SET brand_name = ?, category = ?, description = ?, client_url = ? WHERE id = ?')
            ->execute([$brandName, $category, $description, $clientUrl, $id]);
        $workId = $id;
    } else {
        $maxOrder = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), -1) FROM works')->fetchColumn();
        $pdo->prepare('INSERT INTO works (brand_name, category, description, client_url, sort_order) VALUES (?, ?, ?, ?, ?)')
            ->execute([$brandName, $category, $description, $clientUrl, $maxOrder + 1]);
        $workId = (int) $pdo->lastInsertId();
    }

    // Existing images the client wants to keep, in the desired display order
    $keepIds = [];
    if (isset($_POST['image_order'])) {
        $decoded = json_decode((string) $_POST['image_order'], true);
        if (is_array($decoded)) {
            $keepIds = array_map('intval', $decoded);
        }
    }

    if ($id !== null) {
        $existingStmt = $pdo->prepare('SELECT id, image_path FROM work_images WHERE work_id = ?');
        $existingStmt->execute([$workId]);
        foreach ($existingStmt->fetchAll() as $existing) {
            if (!in_array((int) $existing['id'], $keepIds, true)) {
                $absPath = __DIR__ . '/../uploads/work/' . basename($existing['image_path']);
                if (is_file($absPath)) {
                    unlink($absPath);
                }
                $pdo->prepare('DELETE FROM work_images WHERE id = ?')->execute([$existing['id']]);
            }
        }
        foreach ($keepIds as $order => $imageId) {
            $pdo->prepare('UPDATE work_images SET sort_order = ? WHERE id = ? AND work_id = ?')
                ->execute([$order, $imageId, $workId]);
        }
    }

    // New uploads, appended after the kept images
    $nextOrder = count($keepIds);
    $allowedMime = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $maxBytes = 5 * 1024 * 1024;

    if (!empty($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
        $uploadDir = __DIR__ . '/../uploads/work/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        foreach ($_FILES['images']['tmp_name'] as $i => $tmpPath) {
            if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK || !is_uploaded_file($tmpPath)) {
                continue;
            }
            if ($_FILES['images']['size'][$i] > $maxBytes) {
                throw new RuntimeException('Each image must be 5MB or smaller.', 400);
            }
            $mime = $finfo->file($tmpPath);
            if (!isset($allowedMime[$mime])) {
                throw new RuntimeException('Only JPG, PNG, and WEBP images are allowed.', 400);
            }
            $filename = bin2hex(random_bytes(16)) . '.' . $allowedMime[$mime];
            move_uploaded_file($tmpPath, $uploadDir . $filename);

            $pdo->prepare('INSERT INTO work_images (work_id, image_path, sort_order) VALUES (?, ?, ?)')
                ->execute([$workId, '/uploads/work/' . $filename, $nextOrder]);
            $nextOrder++;
        }
    }

    $pdo->commit();
    respond_json(['success' => true, 'id' => $workId]);
} catch (RuntimeException $e) {
    $pdo->rollBack();
    respond_json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?: 400);
} catch (Throwable $e) {
    $pdo->rollBack();
    respond_json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
}
