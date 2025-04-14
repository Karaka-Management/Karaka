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
    await driver.get(base + '/admin/account/create');
    await driver.sleep(500);

    await driver.findElement(By.css('#iUsername')).sendKeys('test_account');
    await driver.sleep(50);

    await driver.findElement(By.css('#iName1')).sendKeys('Selenium');
    await driver.sleep(50);

    await driver.findElement(By.css('#iName2')).sendKeys('EndToEnd');
    await driver.sleep(50);

    await driver.findElement(By.css('#iEmail')).sendKeys('test@jingga.app');
    await driver.sleep(50);

    await driver.findElement(By.css('#iPassword')).sendKeys('test@jingga.app');
    await driver.sleep(50);

    await driver.findElement(By.id('iCreateAccount')).click();
    await driver.sleep(500);

    await driver.findElement(By.id('account-profile-create')).click();
    await driver.sleep(500);

    await driver.get(base + '/profile/view?id=2');

    await driver.sleep(5000);
    await driver.quit();
})();
