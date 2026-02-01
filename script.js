/**
 * URL Shortener JavaScript
 * Uses modern Fetch API for better performance and readability
 */

// Get DOM elements
const longUrlInput = document.getElementById('longUrl');
const resultDiv = document.getElementById('result');

/**
 * Shorten a URL using the PHP backend
 */
async function shortenUrl() {
    const longUrl = longUrlInput.value.trim();
    
    // Validate input
    if (!longUrl) {
        showResult('Please enter a URL', 'error');
        return;
    }
    
    // Show loading state
    showResult('Generating short URL...', 'loading');
    
    try {
        // Send POST request using fetch API
        const response = await fetch('shorten.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'long_url=' + encodeURIComponent(longUrl)
        });
        
        // Parse JSON response
        const data = await response.json();
        
        if (data.success) {
            // Create clickable link for the short URL
            const shortLink = `<a href="${data.short_url}" target="_blank">${data.short_url}</a>`;
            showResult(`Short URL created: ${shortLink}`, 'success');
            
            // Clear input after successful shortening
            longUrlInput.value = '';
        } else {
            showResult(`Error: ${data.message}`, 'error');
        }
        
    } catch (error) {
        console.error('Error:', error);
        showResult('Network error. Please try again.', 'error');
    }
}

/**
 * Display result message with appropriate styling
 * @param {string} message - Message to display
 * @param {string} type - Message type: 'success', 'error', or 'loading'
 */
function showResult(message, type) {
    resultDiv.innerHTML = message;
    resultDiv.className = 'result ' + type;
    
    // Add appropriate styling based on message type
    switch(type) {
        case 'success':
            resultDiv.style.color = '#28a745';
            resultDiv.style.borderColor = '#28a745';
            break;
        case 'error':
            resultDiv.style.color = '#dc3545';
            resultDiv.style.borderColor = '#dc3545';
            break;
        case 'loading':
            resultDiv.style.color = '#007bff';
            resultDiv.style.borderColor = '#007bff';
            break;
    }
    
    resultDiv.style.display = 'block';
}

// Allow pressing Enter key to submit
longUrlInput.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        shortenUrl();
    }
});
