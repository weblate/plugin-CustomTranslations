/*!
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
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
            controller: 'CustomTranslationsEdit',
            controllerAs: 'editTranslations'
        };
    }
})();