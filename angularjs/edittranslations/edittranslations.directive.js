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

/**
 * Usage:
 * <div matomo-edit-custom-translations>
 */
(function () {
    angular.module('piwikApp').directive('matomoEditCustomTranslations', matomoEditCustomTranslations);

    matomoEditCustomTranslations.$inject = ['piwik'];

    function matomoEditCustomTranslations(piwik){

        return {
            restrict: 'A',
            scope: {},
            templateUrl: 'plugins/CustomTranslations/angularjs/edittranslations/edittranslations.directive.html?cb=' + piwik.cacheBuster,
            controller: 'EdittranslationsController',
            controllerAs: 'editTranslations'
        };
    }
})();