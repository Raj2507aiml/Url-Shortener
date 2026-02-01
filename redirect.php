<?php
// Set proper content type
header('Content-Type: text/html; charset=UTF-8');

// Read URL data from JSON file
$jsonFile = 'urls.json';
$data = [];

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true) ?: [];
}

// Get the short code from URL parameter
$code = isset($_GET['c']) ? trim($_GET['c']) : '';

// Validate short code exists
if (empty($code)) {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Error - URL Shortener</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .error { color: #d9534f; padding: 20px; border: 1px solid #d9534f; border-radius: 5px; }
            a { color: #337ab7; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>Invalid Request</h2>
            <p>No short code provided.</p>
            <p><a href="index.html">Go to URL Shortener</a></p>
        </div>
    </body>
    </html>';
    exit;
}

// Check if the code exists in our data
if (isset($data[$code])) {
    $originalUrl = $data[$code];
    
    // Redirect to the original URL
    header("Location: " . $originalUrl);
    exit;
} else {
    // URL not found - show error page
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>URL Not Found - URL Shortener</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .error { color: #d9534f; padding: 20px; border: 1px solid #d9534f; border-radius: 5px; }
            a { color: #337ab7; }
        </style>
    </head>
    <body>
        <div class="error">
            <h2>URL Not Found</h2>
            <p>The shortened URL you visited does not exist or has been removed.</p>
            <p><a href="index.html">Go to URL Shortener</a></p>
        </div>
    </body>
    </html>';
    exit;
}
?>
