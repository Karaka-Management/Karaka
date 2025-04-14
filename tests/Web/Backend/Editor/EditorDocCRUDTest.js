const {By, Key, Builder, Select} = require("selenium-webdriver");
const chrome = require('selenium-webdriver/chrome');

const base = 'http://192.168.178.38';
const language = 'en';

(async function test() {
    const driver = await new Builder().forBrowser("chrome").build();
    await driver.manage().setTimeouts({ implicit: 3000 });
    await driver.manage().window().setRect({ width: 1920, height: 1080 });
    await driver.get(base);
    await driver.sleep(500);

    ///////////////////////////////////////////////////////////////////////////////////////
    // LOGIN
    ///////////////////////////////////////////////////////////////////////////////////////
    await driver.findElement(By.id('iName')).sendKeys('admin');
    await driver.findElement(By.id('iPassword')).sendKeys('orange');
    await driver.findElement(By.id('iLoginButton')).click();
    await driver.sleep(500);

    ///////////////////////////////////////////////////////////////////////////////////////
    // ACCOUNT TESTS
    ///////////////////////////////////////////////////////////////////////////////////////
    await driver.get(base + '/editor/create');
    await driver.sleep(500);

    await driver.findElement(By.css('input[name=title]')).sendKeys('Test Title');
    await driver.sleep(50);

    await driver.findElement(By.css('textarea[name=plain]')).sendKeys('This is some test content');
    await driver.sleep(50);

    await driver.findElement(By.css('input[name=save-editor]')).click();
    await driver.sleep(3000);

    await driver.get(base + '/editor/view?id=1');
    await driver.sleep(3000);

    await driver.findElement(By.css('#iEditorEdit')).click();
    await driver.sleep(500);
    await driver.findElement(By.css('label[for=editor-c-tab-1]')).click();
    await driver.sleep(50);

    await driver.findElement(By.css('input[name=title]')).clear();
    await driver.findElement(By.css('input[name=title]')).sendKeys('Test New Title');
    await driver.sleep(50);

    await driver.findElement(By.css('textarea[name=plain]')).clear();
    await driver.findElement(By.css('textarea[name=plain]')).sendKeys('This is some other test content');
    await driver.sleep(50);

    await driver.findElement(By.css('input[name=save-editor]')).click();
    await driver.sleep(3000);

    await driver.get(base + '/editor/view?id=1');

    await driver.sleep(5000);
    await driver.quit();
})();
