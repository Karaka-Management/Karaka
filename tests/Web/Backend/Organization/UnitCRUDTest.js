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
    // UNIT TESTS
    ///////////////////////////////////////////////////////////////////////////////////////
    await driver.get(base + '/organization/unit/create');
    await driver.sleep(500);

    await driver.findElement(By.css('#iName')).sendKeys('Test Unit');
    await driver.sleep(50);

    await driver.findElement(By.css('#idescription')).sendKeys('Selenium test unit');
    await driver.sleep(50);

    await driver.findElement(By.css('#iLegalName')).sendKeys('Testing Inc.');
    await driver.sleep(50);

    await driver.findElement(By.css('#iAddress')).sendKeys('Some Street 123');
    await driver.sleep(50);

    await driver.findElement(By.css('#iPostal')).sendKeys('123456');
    await driver.sleep(50);

    await driver.findElement(By.css('#iCity')).sendKeys('Frankfurt');
    await driver.sleep(50);

    const selectElement = await driver.findElement(By.css('#iCountry'));
    const select = new Select(selectElement);
    await select.selectByValue('DE');
    await driver.sleep(50);

    await driver.findElement(By.id('iUnitCreate')).click();
    await driver.sleep(3000);

    await driver.findElement(By.css('#iName')).sendKeys('Testing');
    await driver.sleep(50);

    await driver.findElement(By.id('iSubmit')).click();
    await driver.sleep(500);

    await driver.navigate().refresh();

    await driver.sleep(5000);
    await driver.quit();
})();
