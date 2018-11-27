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

describe("CustomTranslationReporting", function () {
    this.timeout(0);

    this.fixture = "Piwik\\Plugins\\CustomTranslation\\tests\\Fixtures\\CustomTranslationFixture";

    var generalParams = 'idSite=1&period=day&date=2010-01-03',
        urlBase = 'module=CoreHome&action=index&' + generalParams;

    before(function () {
        testEnvironment.pluginsToLoad = ['CustomTranslation', 'CustomReports', 'CustomDimensions'];
        testEnvironment.save();
    });

    it('should load a simple page by its module and action and take a full screenshot', function (done) {
        var screenshotName = 'simplePage';
        // will take a screenshot and store it in "processed-ui-screenshots/CustomTranslationReporting_simplePage.png"
        var urlToTest = "?" + generalParams + "&module=CustomTranslation&action=manage";

        expect.screenshot(screenshotName).to.be.capture(function (page) {
            page.load(urlToTest);
        }, done);
    });

    it('should load a simple page by its module and action and take a partial screenshot', function (done) {
        var screenshotName  = 'simplePagePartial';
        // will take a screenshot and store it in "processed-ui-screenshots/CustomTranslationReporting_simplePagePartial.png"
        var contentSelector = '#root,.expandDataTableFooterDrawer';
        // take a screenshot only of the content of this CSS/jQuery selector
        var urlToTest       = "?" + generalParams + "&module=CustomTranslation&action=manage";
        // "?" + urlBase + "#" + generalParams + "&module=CustomTranslation&action=index"; this defines a URL for a page within the dashboard

        expect.screenshot(screenshotName).to.be.captureSelector(contentSelector, function (page) {
            page.load(urlToTest);
        }, done);
    });
});