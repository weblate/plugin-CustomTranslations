/*!
 * Copyright (C) InnoCraft Ltd - All rights reserved.
 *
 * NOTICE:  All information contained herein is, and remains the property of InnoCraft Ltd.
 * The intellectual and technical concepts contained herein are protected by trade secret or copyright law.
 * Redistribution of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from InnoCraft Ltd.
 *
 * You shall use this code only in accordance with the license agreement obtained from InnoCraft Ltd.
 *
 * @link https://www.innocraft.com/
 * @license For license details see https://www.innocraft.com/license
 */

describe("CustomTranslationManage", function () {
    this.timeout(0);

    this.fixture = "Piwik\\Plugins\\CustomTranslation\\tests\\Fixtures\\CustomTranslationFixture";

    var url = '?module=CustomTranslation&action=manage&idSite=1&period=day&date=2010-01-03';

    before(function () {
        testEnvironment.pluginsToLoad = ['CustomTranslation', 'CustomReports', 'CustomDimensions'];
        testEnvironment.save();
    });

    function setTranslation(page, type, row, translation, setKey)
    {
        var fieldClass = '.fieldUiControl2';
        if (setKey) {
            fieldClass = '.fieldUiControl1'
        }

        var selector = '.translationType' + type + ' .multiPairFieldTable' + row + ' '+ fieldClass + ' .control_text';
        page.execCallback(function () {
            page.webpage.evaluate(function(selector) {
                $(selector).val('').change();
            }, selector);

            page.webpage.evaluate(function(selector, text) {
                $(selector).val(text).change();
            }, selector, translation);
        });
    }

    function saveTranslation(page, type)
    {
        page.click('.translationType' + type + ' [piwik-save-button] .btn');
    }

    it('should load manage page', function (done) {
        expect.screenshot('loaded').to.be.captureSelector('.pageWrap', function (page) {
            page.load(url);
        }, done);
    });

    it('should be possible to enter values', function (done) {
        expect.screenshot('values_entered').to.be.captureSelector('.pageWrap', function (page) {
            setTranslation(page, 'customDimensionEntity', 0, 'newValue1');
            setTranslation(page, 'customDimensionEntity', 1, 'newKey2');
            setTranslation(page, 'customDimensionEntity', 1, 'newValue2', true);
            saveTranslation(page, 'customDimensionEntity');

            setTranslation(page, 'eventLabel', 0, 'eventVal1');
            setTranslation(page, 'eventLabel', 2, 'eventKey');
            setTranslation(page, 'eventLabel', 2, 'eventVal2', true);
            saveTranslation(page, 'eventLabel');
        }, done);
    });

    it('should show save values on reload', function (done) {
        expect.screenshot('values_saved_verify').to.be.captureSelector('.pageWrap', function (page) {
            page.load(url);
        }, done);
    });
});