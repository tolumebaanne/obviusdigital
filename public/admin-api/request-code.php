<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$submittedEmail = is_array($input) ? ($input['email'] ?? '') : ($_POST['email'] ?? '');
$submittedEmail = strtolower(trim((string) $submittedEmail));

if (!filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
    respond_json(['success' => false, 'message' => 'Enter a valid email address.'], 400);
}

$pdo = get_pdo();
$ip = client_ip();

// Opportunistic cleanup of old rows
$pdo->exec('DELETE FROM login_codes WHERE created_at < (NOW() - INTERVAL 1 DAY)');
$pdo->exec('DELETE FROM code_requests WHERE requested_at < (NOW() - INTERVAL 1 DAY)');

// Rate limiting — m0t.AUTH.6.4 (max 3 code requests / 15 minutes per IP, so
// this endpoint can't be used to spam the admin inbox).
$stmt = $pdo->prepare('SELECT COUNT(*) FROM code_requests WHERE ip_address = ? AND requested_at > (NOW() - INTERVAL 15 MINUTE)');
$stmt->execute([$ip]);
if ((int) $stmt->fetchColumn() >= 3) {
    respond_json(['success' => false, 'message' => 'Too many requests. Try again in 15 minutes.'], 429);
}

// Every attempt counts against the rate limit, matching email or not.
$pdo->prepare('INSERT INTO code_requests (ip_address) VALUES (?)')->execute([$ip]);

$stmt = $pdo->prepare('SELECT is_admin FROM admin_emails WHERE email = ?');
$stmt->execute([$submittedEmail]);
$authorized = $stmt->fetch();

// Only registered addresses ever get a code. The response is identical
// either way so this endpoint can't be used to discover who's authorized
// (m0t.AUTH.3.5 — error messages must not leak information).
if ($authorized !== false) {
    // Codes are short-lived, single-use, and capped at 5 guesses — m0t.AUTH.2.5
    // (Authorization Codes Are Ephemeral) applied to a login code rather than
    // an OAuth grant. 8 alphanumeric characters (~2.8 trillion combinations);
    // O/0 and I/1 are excluded so it's unambiguous to type back.
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < 8; $i++) {
        $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
    }
    $codeHash = password_hash($code, PASSWORD_BCRYPT);
    $expiresAt = (new DateTimeImmutable('+10 minutes'))->format('Y-m-d H:i:s');
    $isAdmin = (int) $authorized['is_admin'];

    $pdo->prepare('INSERT INTO login_codes (email, is_admin, code_hash, expires_at, ip_address) VALUES (?, ?, ?, ?, ?)')
        ->execute([$submittedEmail, $isAdmin, $codeHash, $expiresAt, $ip]);

    $subject = 'Your Obvius Digital admin login code';
    $body = "Your login code is: {$code}\n\nThis code expires in 10 minutes and can only be used once.\n\nIf you didn't request this, you can ignore this email.";
    $headers = implode("\r\n", [
        'From: Obvius Digital <hello@obviusdigital.ca>',
        'X-Mailer: PHP/' . phpversion(),
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
    ]);

    mail($submittedEmail, $subject, $body, $headers);
}

respond_json(['success' => true, 'message' => 'If that address is registered, a code has been sent.']);
