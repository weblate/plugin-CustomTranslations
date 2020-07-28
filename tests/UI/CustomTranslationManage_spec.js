/*!
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */


describe("CustomTranslationManage", function () {
    this.timeout(0);

    this.fixture = "Piwik\\Plugins\\CustomTranslations\\tests\\Fixtures\\CustomTranslationsFixture";
    this.optionsOverride = {
        'persist-fixture-data': false
    };

    var url = '?module=CustomTranslations&action=manage&idSite=1&period=day&date=2010-01-03';

    before(function () {
        testEnvironment.pluginsToLoad = ['CustomTranslations', 'CustomReports', 'CustomDimensions'];
        testEnvironment.save();
    });

    async function setTranslation(page, type, row, translation, setKey)
    {
        var fieldClass = '.fieldUiControl2';
        if (setKey) {
            fieldClass = '.fieldUiControl1'
        }

        var selector = '.translationType' + type + ' .multiPairFieldTable' + row + ' '+ fieldClass + ' .control_text';
        await page.webpage.evaluate(function(selector) {
            $(selector).val('').change();
        }, selector);

        await page.webpage.evaluate(function(selector, text) {
            $(selector).val(text).change();
        }, selector, translation);
    }

    async function saveTranslation(page, type)
    {
        await page.click('.translationType' + type + ' [piwik-save-button] .btn');
    }

    it('should load manage page', async function () {
        await page.goto(url);
        expect(await page.screenshotSelector('.pageWrap')).to.matchImage('loaded');
    });

    it('should be possible to enter values', async function () {
        await setTranslation(page, 'customDimensionEntity', 0, 'newValue1');
        await setTranslation(page, 'customDimensionEntity', 1, 'newKey2');
        await setTranslation(page, 'customDimensionEntity', 1, 'newValue2', true);
        await saveTranslation(page, 'customDimensionEntity');
        await setTranslation(page, 'eventLabel', 0, 'eventVal1');
        await setTranslation(page, 'eventLabel', 2, 'eventKey');
        await setTranslation(page, 'eventLabel', 2, 'eventVal2', true);
        await saveTranslation(page, 'eventLabel');
    });

    it('should show save values on reload', async function () {
        await page.goto(url);
        expect(await page.screenshotSelector('.pageWrap')).to.matchImage('values_saved_verify');
    });
});