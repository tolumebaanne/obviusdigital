<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Accept JSON payload (fetch API) or standard form POST
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
if (is_array($input)) {
    $_POST = array_merge($_POST, $input);
}

// Server-side sanitization (m0t.BUILDER.4.2 — Trust Boundaries Must Be Enforced)
$sanitize = function($val) {
    return htmlspecialchars(strip_tags(trim((string)$val)), ENT_QUOTES, 'UTF-8');
};

// Required: name and email are always required (standard contact + RFP)
$name  = isset($_POST['name'])  ? $sanitize($_POST['name'])  : '';
$email = isset($_POST['email']) ? $sanitize($_POST['email']) : '';

if (empty($name) || empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name and email are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'A valid email address is required.']);
    exit;
}

// RFP-specific required fields (all questions mandatory per m0t.FLOW.4.3)
$rfpFields = ['primary_goal', 'estimated_investment', 'launch_timeline', 'business_name', 'phone_number'];
foreach ($rfpFields as $field) {
    $val = isset($_POST[$field]) ? trim((string)$_POST[$field]) : '';
    // Only enforce if this looks like an RFP submission (primary_goal present)
    if (isset($_POST['primary_goal']) && empty($val)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }
}

// Build dynamic email body
$body = "New RFP/Contact submission from obviusdigital.ca\n";
$body .= str_repeat('-', 50) . "\n\n";

foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        $value = implode(', ', array_map($sanitize, $value));
    } else {
        $value = $sanitize($value);
    }
    $formattedKey = ucwords(str_replace(['_', '-'], ' ', $key));
    $body .= "{$formattedKey}: {$value}\n";
}

$to      = 'hello@obviusdigital.ca';
$subject = 'New RFP from ' . $name;
$headers = implode("\r\n", [
    'From: Obvius Digital <hello@obviusdigital.ca>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
]);

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Sent successfully.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send. Please try again.']);
}
