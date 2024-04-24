const {By, Key, Builder} = require("selenium-webdriver");
const chrome = require('selenium-webdriver/chrome');

const base = 'http://192.168.178.38';
const language = 'en';

(async function test() {
    const driver = await new Builder().forBrowser("chrome").build();
    await driver.manage().setTimeouts({ implicit: 3000 });
    await driver.manage().window().setRect({ width: 1920, height: 1080 });

    ///////////////////////////////////////////////////////////////////////////////////////
    // INSTALL
    ///////////////////////////////////////////////////////////////////////////////////////
    await driver.get(base + '/Install');
    await driver.sleep(500);

    await driver.findElement(By.css('#page-1 .next')).click();
    await driver.sleep(500);
    await driver.findElement(By.css('#page-2 .next')).click();
    await driver.sleep(500);
    await driver.findElement(By.css('#page-3 .next')).click();

    await driver.sleep(500);
    await driver.findElement(By.id('iDbName')).clear();
    await driver.findElement(By.id('iDbName')).sendKeys('omt');

    await driver.findElement(By.id('iSchemaUser')).sendKeys('test');
    await driver.findElement(By.id('iSchemaPassword')).sendKeys('orange');

    await driver.findElement(By.id('iCreateUser')).sendKeys('test');
    await driver.findElement(By.id('iCreatePassword')).sendKeys('orange');

    await driver.findElement(By.id('iSelectUser')).sendKeys('test');
    await driver.findElement(By.id('iSelectPassword')).sendKeys('orange');

    await driver.findElement(By.id('iUpdateUser')).sendKeys('test');
    await driver.findElement(By.id('iUpdatePassword')).sendKeys('orange');

    await driver.findElement(By.id('iDeleteUser')).sendKeys('test');
    await driver.findElement(By.id('iDeletePassword')).sendKeys('orange');
    await driver.sleep(500);

    await driver.findElement(By.css('#page-4 .next')).click();
    await driver.sleep(500);

    await driver.findElement(By.id('iAdminPassword')).sendKeys('orange');
    await driver.findElement(By.id('iAdminEmail')).sendKeys('info@jingga.app');
    await driver.sleep(500);

    await driver.findElement(By.css('button[type=submit]')).click();
    await driver.sleep(30000);

    ///////////////////////////////////////////////////////////////////////////////////////
    // LOGIN
    ///////////////////////////////////////////////////////////////////////////////////////
    await driver.findElement(By.id('iName')).sendKeys('admin');
    await driver.findElement(By.id('iPassword')).sendKeys('orange');
    await driver.findElement(By.id('iLoginButton')).click();

    await driver.sleep(5000);
    await driver.quit();
})();
