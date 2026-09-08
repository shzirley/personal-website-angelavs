// Run with Playwright installed or NODE_PATH pointing to the bundled runtime.
const { chromium } = require('playwright');
const fs = require('node:fs');
const path = require('node:path');
const assert = require('node:assert/strict');

(async () => {
    const output = path.join(__dirname, 'browser-output');
    fs.mkdirSync(output, { recursive: true });
    const browser = await chromium.launch({ headless: true, channel: process.env.PLAYWRIGHT_CHANNEL || 'chrome' });
    const page = await browser.newPage({ viewport: { width: 1440, height: 1000 }, deviceScaleFactor: 1 });
    const failures = [];
    page.on('pageerror', error => failures.push(error.message));
    page.on('response', response => {
        if (response.status() >= 400 && /\.(css|js|png|woff2|svg)(\?|$)/.test(response.url())) failures.push(response.url());
    });
    const base = process.env.ANGELA_PREVIEW_URL || 'http://127.0.0.1:8012';
    const routes = ['/', '/mahasiswa/5025241226', '/projects', '/projects/claritas', '/projects/tappcom', '/projects/green-saldo', '/calculator', '/dashboard', '/collection', '/contact', '/resume'];
    for (const width of [1440, 768, 390, 320]) {
        await page.setViewportSize({ width, height: 1000 });
        for (const route of routes) {
            const response = await page.goto(base + route);
            assert.equal(response.status(), 200, `${route} @${width}`);
            await page.evaluate(() => document.fonts.ready);
            const overflow = await page.evaluate(() => document.documentElement.scrollWidth > innerWidth);
            assert.equal(overflow, false, `Horizontal overflow: ${route} @${width}`);
            const brokenImages = await page.locator('img').evaluateAll(images => images.filter(image => image.complete && image.naturalWidth === 0).length);
            assert.equal(brokenImages, 0, `Broken image: ${route}`);
        }
    }
    await page.setViewportSize({ width: 1440, height: 1000 });
    await page.goto(base);
    await page.evaluate(() => document.fonts.ready);
    await page.waitForTimeout(900);
    await page.screenshot({ path: path.join(output, 'home-desktop.png') });
    await page.getByRole('navigation').getByRole('link', { name: 'About', exact: true }).click();
    assert.match(page.url(), /mahasiswa\/5025241226/);
    await page.getByRole('navigation', { name: 'Main navigation' }).getByRole('link', { name: 'Projects', exact: true }).click();
    await page.getByRole('link', { name: /CLARITAS/ }).first().click();
    await page.getByRole('link', { name: /Next project: TAPPCOM/ }).click();
    await page.getByRole('heading', { name: 'TAPPCOM.' }).waitFor();
    await page.getByRole('button', { name: 'Close project preview' }).click();
    await page.getByText('project-preview.png was closed.').waitFor();
    await page.getByRole('button', { name: /Restore window/ }).click();
    await page.getByRole('button', { name: 'Expand project preview' }).click();
    assert.equal(await page.locator('[data-closable-window]').evaluate(element => element.classList.contains('is-maximized')), true);
    await page.getByRole('button', { name: 'Expand project preview' }).click();
    await page.getByRole('navigation').getByRole('link', { name: 'Calculator', exact: true }).click();
    await page.getByLabel('Semester 01').fill('3,50');
    await page.getByLabel('Semester 02').fill('3.80');
    await page.getByRole('button', { name: /Calculate average/ }).click();
    assert.equal(await page.locator('.result-number').textContent(), '3.65');
    await page.waitForTimeout(700);
    await page.screenshot({ path: path.join(output, 'calculator-desktop.png') });
    await page.getByLabel('Semester 01').fill('5');
    await page.getByRole('button', { name: /Calculate average/ }).click();
    assert.equal(await page.locator('#ip1').getAttribute('aria-invalid'), 'true');
    await page.getByRole('link', { name: 'Reset', exact: true }).click();
    assert.equal(await page.locator('#ip1').inputValue(), '');
    await page.emulateMedia({ reducedMotion: 'reduce' });
    await page.goto(base);
    assert.equal(await page.locator('html').evaluate(element => element.classList.contains('motion-off')), true);
    await page.emulateMedia({ reducedMotion: 'no-preference' });
    await page.getByRole('button', { name: 'Motion: on' }).click();
    await page.reload();
    await page.getByRole('button', { name: 'Motion: off' }).waitFor();
    await page.getByRole('button', { name: 'Motion: off' }).click();
    await page.goto(base);
    await page.getByRole('button', { name: 'Flip profile card' }).first().click();
    assert.equal(await page.locator('[data-flip-card]').evaluate(element => element.classList.contains('is-flipped')), true);
    await page.getByRole('button', { name: 'Pet the walking robot cat' }).click({ force: true });
    assert.match(await page.locator('[data-cat-speech]').textContent(), /mrrp/);
    await page.getByRole('button', { name: /Play/ }).click();
    assert.match(await page.locator('[data-music-embed] iframe').getAttribute('src'), /youtube-nocookie/);
    await page.getByRole('button', { name: 'Stop music and close player' }).click();
    await page.getByRole('button', { name: 'Switch to midnight terminal' }).click();
    assert.equal(await page.locator('html').getAttribute('data-theme'), 'terminal');
    await page.reload();
    await page.getByRole('button', { name: 'Switch to pink desktop' }).waitFor();
    assert.equal(await page.locator('html').getAttribute('data-theme'), 'terminal');
    await page.waitForTimeout(500);
    await page.screenshot({ path: path.join(output, 'home-terminal-desktop.png') });
    await page.setViewportSize({ width: 390, height: 900 });
    assert.equal(await page.evaluate(() => document.documentElement.scrollWidth > innerWidth), false, 'Horizontal overflow: terminal Home @390');
    await page.screenshot({ path: path.join(output, 'home-terminal-mobile.png'), fullPage: true });
    await page.setViewportSize({ width: 1440, height: 1000 });
    await page.getByRole('button', { name: 'Switch to pink desktop' }).click();
    assert.equal(await page.locator('html').getAttribute('data-theme'), null);
    const balloons = page.locator('[data-pop-balloon]');
    for (let index = 0; index < await balloons.count(); index += 1) await balloons.nth(index).click({ force: true });
    assert.equal(await page.locator('[data-bubble-count]').textContent(), '8');
    await page.getByText('Secret unlocked: joy.exe completed!').waitFor();
    await page.getByRole('button', { name: /Play again/ }).click();
    assert.equal(await page.locator('[data-bubble-count]').textContent(), '0');
    for (const width of [1440, 390]) {
        await page.setViewportSize({ width, height: 900 });
        await page.goto(base);
        for (let y = 0; y < await page.evaluate(() => document.documentElement.scrollHeight); y += 600) {
            await page.evaluate(y => scrollTo(0, y), y);
            await page.waitForTimeout(120);
        }
        await page.evaluate(() => scrollTo({ top: 0, behavior: 'instant' }));
        await page.waitForTimeout(800);
        await page.screenshot({ path: path.join(output, `home-${width}-full.png`), fullPage: true });
    }
    const noJS = await browser.newPage({ javaScriptEnabled: false, viewport: { width: 390, height: 844 } });
    await noJS.goto(base + '/calculator');
    await noJS.getByLabel('Semester 01').fill('3.5');
    await noJS.getByLabel('Semester 02').fill('3.8');
    await noJS.getByRole('button', { name: /Calculate average/ }).click();
    assert.equal(await noJS.locator('.result-number').textContent(), '3.65');
    await noJS.close();
    assert.deepEqual(failures, []);
    console.log('PASS: responsive routes, assets, terminal theme, balloon game, project controls, flip card, cat, music, calculator, motion preferences, and no-JS calculator.');
    await browser.close();
})().catch(error => { console.error(error); process.exit(1); });
