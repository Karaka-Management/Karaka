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
    // SETUP SERVER EMAIL
    ///////////////////////////////////////////////////////////////////////////////////////
    await driver.get(base + '/admin/module/settings?id=Admin');
    await driver.sleep(500);

    await driver.findElement(By.css('#iOutServer')).clear();
    await driver.findElement(By.css('#iOutServer')).sendKeys('mail.privateemail.com');
    await driver.sleep(50);

    await driver.findElement(By.css('#iOutPort')).clear();
    await driver.findElement(By.css('#iOutPort')).sendKeys('587');
    await driver.sleep(50);

    await driver.findElement(By.css('#iInServer')).clear();
    await driver.findElement(By.css('#iInServer')).sendKeys('mail.privateemail.com');
    await driver.sleep(50);

    await driver.findElement(By.css('#iInPort')).clear();
    await driver.findElement(By.css('#iInPort')).sendKeys('993');
    await driver.sleep(50);

    const selectElement = await driver.findElement(By.css('#iEmailType'));
    const select = new Select(selectElement);
    await select.selectByValue('smtp');
    await driver.sleep(50);

    await driver.findElement(By.css('#iEmailUsername')).clear();
    await driver.findElement(By.css('#iEmailUsername')).sendKeys('info@jingga.app');
    await driver.sleep(50);

    await driver.findElement(By.css('#iEmailPassword')).clear();
    await driver.findElement(By.css('#iEmailPassword')).sendKeys('fakepassword');
    await driver.sleep(50);

    await driver.findElement(By.css('#iEmailAddress')).clear();
    await driver.findElement(By.css('#iEmailAddress')).sendKeys('info@jingga.app');
    await driver.sleep(50);

    await driver.findElement(By.id('iSubmitEmail')).click();
    await driver.sleep(500);

    await driver.navigate().refresh();

    await driver.sleep(5000);
    await driver.quit();
})();
