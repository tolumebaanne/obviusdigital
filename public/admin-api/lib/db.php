<?php
declare(strict_types=1);

require_once __DIR__ . '/../config.php';

// Pages (beyond the /work grid, which always shows everything) that a work
// item can be pinned to. Keep in sync with the checkboxes in
// src/pages/admin/edit.astro.
const PINNABLE_PAGES = [
    'home' => 'Home',
    'web-dev' => 'Web Design',
    'production' => '360 Media Production',
    'digital-marketing' => 'Digital Marketing',
    'consulting' => 'Consulting',
    'training' => 'Training',
];

function get_pdo(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }
    return $pdo;
}

function respond_json(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}
