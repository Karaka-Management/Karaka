const { Builder, By } = require('selenium-webdriver');
const Jasmine = require('jasmine');
const SpecReporter = require('jasmine-spec-reporter');

describe('Site Existence Test', function() {
    let driver;

    // Set the timeout for async operations
    jasmine.DEFAULT_TIMEOUT_INTERVAL = 10000; // 10 seconds

    // Jasmine hooks: BeforeAll and AfterAll
    beforeAll(async function() {
        driver = await new Builder().forBrowser('chrome').build();
    });

    afterAll(async function() {
        await driver.quit();
    });

    it('should check if 127.0.0.1 exists', async function() {
        await driver.get('http://127.0.0.1');

        // Check if the title contains "127.0.0.1"
        const title = await driver.getTitle();
        expect(title).toContain('127.0.0.1');
    });
});

// Run the Jasmine test
const jasmineRunner = new Jasmine();
jasmineRunner.loadConfig({
    spec_dir: '',
    spec_files: ['test.js'], // Change this to match your test file name
    helpers: [],
    stopSpecOnExpectationFailure: false,
    random: false,
});
jasmineRunner.clearReporters(); // Clear default console reporter
jasmineRunner.addReporter(new SpecReporter({ spec: { displayPending: true } }));
jasmineRunner.execute();