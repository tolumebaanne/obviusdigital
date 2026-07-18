<?php
declare(strict_types=1);

// Public, unauthenticated read endpoint. The live "Our Work" page fetches this
// at runtime so new admin entries appear without a rebuild/redeploy.

require_once __DIR__ . '/admin-api/lib/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

try {
    $pdo = get_pdo();
    $works = $pdo->query('SELECT id, brand_name AS brandName, category, description, client_url AS clientUrl FROM works ORDER BY sort_order ASC, id DESC')->fetchAll();

    $imgStmt = $pdo->prepare('SELECT image_path FROM work_images WHERE work_id = ? ORDER BY sort_order ASC, id ASC');
    foreach ($works as &$work) {
        $imgStmt->execute([$work['id']]);
        $work['images'] = array_column($imgStmt->fetchAll(), 'image_path');
        unset($work['id']);
    }
    unset($work);

    respond_json(['success' => true, 'works' => $works]);
} catch (Throwable $e) {
    // Degrade gracefully rather than exposing a fatal error to visitors (m0t.FLOW.6.5)
    respond_json(['success' => false, 'works' => []], 200);
}
