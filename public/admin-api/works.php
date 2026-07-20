<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$pdo = get_pdo();
$works = $pdo->query('SELECT id, brand_name, category, description, client_url, thumbnail_path, is_published, sort_order FROM works ORDER BY sort_order ASC, id DESC')->fetchAll();

$imgStmt = $pdo->prepare('SELECT id, image_path FROM work_images WHERE work_id = ? ORDER BY sort_order ASC, id ASC');
$pageStmt = $pdo->prepare('SELECT page_slug FROM work_pages WHERE work_id = ?');
foreach ($works as &$work) {
    $imgStmt->execute([$work['id']]);
    $work['images'] = $imgStmt->fetchAll();
    // Fall back to the first gallery image for entries created before the
    // dedicated thumbnail field existed.
    $work['thumbnail'] = $work['thumbnail_path'] ?? ($work['images'][0]['image_path'] ?? null);

    $pageStmt->execute([$work['id']]);
    $work['pages'] = array_column($pageStmt->fetchAll(), 'page_slug');
}
unset($work);

respond_json(['success' => true, 'works' => $works]);
