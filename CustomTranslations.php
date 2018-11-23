<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations;

use Piwik\API\Request;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugins\CustomTranslations\TranslationTypes\TranslationTypeProvider;
use Piwik\SettingsServer;

class CustomTranslations extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'API.Request.dispatch.end' => 'updateEvents',
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'Translate.getClientSideTranslationKeys' => 'getClientSideTranslationKeys',
        );
    }

    public function getClientSideTranslationKeys(&$result)
    {
        $result[] = 'General_Language';
        $result[] = 'General_Value';
        $result[] = 'General_GoTo2';
        $result[] = 'CustomTranslations_Translation';
        $result[] = 'CustomTranslations_LanguageInlineHelp';
        $result[] = 'CustomTranslations_CustomTranslations';
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/CustomTranslations/angularjs/edittranslations/edittranslations.directive.less";
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/CustomTranslations/angularjs/edittranslations/edittranslations.controller.js";
        $jsFiles[] = "plugins/CustomTranslations/angularjs/edittranslations/edittranslations.directive.js";
    }

    public function isTrackerPlugin()
    {
        return false;
    }

    public function updateEvents(&$returnedValue, $extraInfo)
    {
        if (empty($extraInfo['module']) || empty($extraInfo['action'])) {
            return;
        }

        if (SettingsServer::isTrackerApiRequest()) {
            return;
        }

        if (SettingsServer::isArchivePhpTriggered()) {
            return;
        }

        if (!Piwik::isUserHasSomeViewAccess()) {
            return;
        }

        if (Request::getRootApiRequestMethod() === 'API.getSuggestedValuesForSegment') {
            // we need to make sure to return the raw words here
            return;
        }

        $module = $extraInfo['module'];
        $action = $extraInfo['action'];
        $method = $module . '.' . $action;

        $provider = StaticContainer::get(TranslationTypeProvider::class);

        foreach ($provider->getAllTranslationTypes() as $type) {
            $returnedValue = $type->translate($returnedValue, $method, $extraInfo);
        }
    }

}
