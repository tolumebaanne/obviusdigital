<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

require_auth();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$pdo = get_pdo();
$works = $pdo->query('SELECT id, brand_name, category, description, client_url, sort_order FROM works ORDER BY sort_order ASC, id DESC')->fetchAll();

$imgStmt = $pdo->prepare('SELECT id, image_path FROM work_images WHERE work_id = ? ORDER BY sort_order ASC, id ASC');
foreach ($works as &$work) {
    $imgStmt->execute([$work['id']]);
    $work['images'] = $imgStmt->fetchAll();
}
unset($work);

respond_json(['success' => true, 'works' => $works]);
