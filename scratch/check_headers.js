const fs = require('fs');
const html = fs.readFileSync('c:/xampp/htdocs/livrcart/demoark/api/last_email_payload.html', 'utf8');

const matches = html.match(/<(h[1-6]|div|span)[^>]*class=["'][^"']*(?:title|heading|header|page)[^"']*["'][^>]*>([^<]+)<\/\1>/gi);
console.log('Class matching titles:', matches ? matches.slice(0, 30) : 'none');

// Also find all table headers
const ths = html.match(/<th[^>]*>([^<]+)<\/th>/gi);
console.log('Ths:', ths ? ths.slice(0, 30) : 'none');
