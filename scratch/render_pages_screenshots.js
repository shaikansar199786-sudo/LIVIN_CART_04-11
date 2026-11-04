const puppeteer = require('C:/xampp/htdocs/livrcart/demoark/frontend/node_modules/puppeteer');
const fs = require('fs');

(async () => {
    const html = fs.readFileSync('c:/xampp/htdocs/livrcart/scratch/quote297_generated.html', 'utf8');
    const browser = await puppeteer.launch({ headless: 'new', args: ['--no-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 794, height: 1123, deviceScaleFactor: 2 }); // A4 at 96 DPI
    await page.setContent(html, { waitUntil: 'load' });

    // Find all page-wrap elements
    const pageWraps = await page.$$('.page-wrap, .page-wrap-last');
    console.log('Found page wraps: ' + pageWraps.length);

    for (let i = 0; i < pageWraps.length; i++) {
        const outPath = `C:/Users/Shaik Ansar/.gemini/antigravity-ide/brain/91c581a2-b340-4403-af55-f4e3d0a202c7/page_${i + 1}_preview.png`;
        await pageWraps[i].screenshot({ path: outPath });
        console.log(`Saved page ${i + 1} screenshot to: ${outPath}`);
    }

    await browser.close();
    console.log('Done screenshots!');
})();
