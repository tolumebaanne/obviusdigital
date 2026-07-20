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

    $pageSlug = isset($_GET['page']) ? trim((string) $_GET['page']) : '';
    if ($pageSlug !== '' && isset(PINNABLE_PAGES[$pageSlug])) {
        $stmt = $pdo->prepare('SELECT id, brand_name AS brandName, category, description, client_url AS clientUrl, thumbnail_path AS thumbnail FROM works WHERE is_published = 1 AND id IN (SELECT work_id FROM work_pages WHERE page_slug = ?) ORDER BY sort_order ASC, id DESC');
        $stmt->execute([$pageSlug]);
        $works = $stmt->fetchAll();
    } else {
        $works = $pdo->query('SELECT id, brand_name AS brandName, category, description, client_url AS clientUrl, thumbnail_path AS thumbnail FROM works WHERE is_published = 1 ORDER BY sort_order ASC, id DESC')->fetchAll();
    }

    $imgStmt = $pdo->prepare('SELECT image_path FROM work_images WHERE work_id = ? ORDER BY sort_order ASC, id ASC');
    foreach ($works as &$work) {
        $imgStmt->execute([$work['id']]);
        $work['images'] = array_column($imgStmt->fetchAll(), 'image_path');
        // Fall back to the first gallery image for entries created before the
        // dedicated thumbnail field existed.
        if ($work['thumbnail'] === null) {
            $work['thumbnail'] = $work['images'][0] ?? null;
        }
        unset($work['id']);
    }
    unset($work);

    respond_json(['success' => true, 'works' => $works]);
} catch (Throwable $e) {
    // Degrade gracefully rather than exposing a fatal error to visitors (m0t.FLOW.6.5)
    respond_json(['success' => false, 'works' => []], 200);
}
