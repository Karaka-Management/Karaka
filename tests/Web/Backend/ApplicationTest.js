const {By, Key, Builder} = require("selenium-webdriver");
const chrome = require('selenium-webdriver/chrome');

let fs = require('fs');
let path = require('path');

const base = 'http://192.168.178.38';
const language = 'en';
const src = [
    'legal/privacy',
    'legal/terms',
    'legal/imprint',
];
const length = src.length;

async function checkEndpoint(driver, url) {
    await driver.get(url);

    try {
        await driver.findElement(By.xpath('//*[@alt="404 error image"]'));

        return -1;
    } catch(error) {
        return 0;
    } finally {
        /*
    	const data = await driver.takeScreenshot(true);
    	await fs.writeFileSync('C:/Users/spl1nes/screenshots/' + url.replace(/[^a-z0-9]/gi, '_').toLowerCase() + '.png', data, 'base64');
        */
    }
}

/*
let dir = path.dirname('C:/Users/spl1nes/screenshots/');
if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
}
*/

(async function loop() {
    const driver = await new Builder().forBrowser("chrome").build();
    await driver.get(base);
    await driver.manage().setTimeouts({ implicit: 3000 });
    await driver.manage().window().setRect({ width: 1920, height: 1080 });
    await driver.findElement(By.id('iLoginButton')).click();
    await driver.sleep(1000);

    let status = 0;

    for (let i = 0; i < length; ++i) {
        try {
            status = await checkEndpoint(driver, base + '/' + language + '/' + src[i]);
        } catch(error) {
            console.error(error);
        }

        describe('Site Existence Test', function() {
            it('should check if 127.0.0.1 exists', function () {
                expect(status).toBe(0);
            });
        });

        if (status !== 0) {
            console.error(status +': ' + src[i]);
            status = 0;
        }
    }

    await driver.quit();
})();
