<?php
// Start session to handle errors and messages
session_start();

// Set proper content type for JSON responses
header('Content-Type: application/json');

// Read existing URLs from JSON file
$jsonFile = 'urls.json';
$data = [];

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true) ?: [];
}

// Get the long URL from POST request
$longUrl = isset($_POST['long_url']) ? trim($_POST['long_url']) : '';

// Validate input
if (empty($longUrl)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a URL'
    ]);
    exit;
}

// Validate URL format
if (!filter_var($longUrl, FILTER_VALIDATE_URL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid URL (include http:// or https://)'
    ]);
    exit;
}

// Generate unique short code
$code = substr(md5($longUrl . time()), 0, 6);

// Store the URL mapping
$data[$code] = $longUrl;

// Save back to JSON file
file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

// Return success response with short URL
$shortUrl = 'redirect.php?c=' . $code;
echo json_encode([
    'success' => true,
    'short_url' => $shortUrl,
    'full_short_url' => 'http://localhost/url-shortener/' . $shortUrl
]);
?>
