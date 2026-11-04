const fs = require('fs');
const html = fs.readFileSync('c:/xampp/htdocs/livrcart/demoark/api/last_email_payload.html', 'utf8');

['pdf-page-1', 'pdf-page-2', 'pdf-page-3', 'pdf-page-4'].forEach(id => {
    const search = 'id="' + id + '"';
    const pos = html.indexOf(search);
    if (pos !== -1) {
        console.log('=== ' + id + ' ===');
        const snippet = html.slice(pos, pos + 2500)
            .replace(/<style[\s\S]*?<\/style>/g, '')
            .replace(/data:image\/[^;]+;base64,[^"'\s]+/g, '[BASE64_IMAGE]')
            .replace(/<[^>]+>/g, ' ')
            .replace(/\s+/g, ' ');
        console.log(snippet.slice(0, 350));
    } else {
        console.log('=== ' + id + ' NOT FOUND ===');
    }
});
