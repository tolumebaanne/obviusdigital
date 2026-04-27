<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get raw JSON payload if available (fetch API often sends JSON)
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if (is_array($input)) {
    $_POST = array_merge($_POST, $input);
}

// Ensure required fields exist
$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';

if (empty($name) || empty($email)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name and email are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Build dynamic body
$body = "New submission received:\n\n";
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        $value = implode(', ', array_map('strip_tags', $value));
    } else {
        $value = strip_tags($value);
    }
    // Format key for readability (e.g. "business_name" -> "Business Name")
    $formattedKey = ucwords(str_replace(['_', '-'], ' ', $key));
    $body .= "$formattedKey: $value\n";
}

$to      = 'hello@obviusdigital.ca';
$subject = 'New Form Submission from ' . $name;
$headers = "From: Obvius Digital <hello@obviusdigital.ca>\r\nReply-To: $name <$email>\r\nX-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send message']);
}
?>
