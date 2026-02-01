<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>🔗 URL Shortener</h1>
    
    <div class="input-group">
        <input 
            type="url" 
            id="longUrl" 
            placeholder="Enter long URL (e.g., https://example.com/very/long/url)" 
            required
            autocomplete="url"
        >
        <button onclick="shortenUrl()">Shorten URL</button>
    </div>

    <div id="result" class="result"></div>
    
    <div class="info">
        <p>Enter a long URL above and click "Shorten URL" to generate a short link.</p>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
