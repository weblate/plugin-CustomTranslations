<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation;

use Piwik\API\Request;
use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugins\CustomTranslation\TranslationTypes\TranslationTypeProvider;
use Piwik\SettingsServer;

class CustomTranslation extends \Piwik\Plugin
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
        $result[] = 'CustomTranslation_Translation';
        $result[] = 'CustomTranslation_LanguageInlineHelp';
        $result[] = 'CustomTranslation_CustomTranslation';
    }

    public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/CustomTranslation/angularjs/edittranslations/edittranslations.directive.less";
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = "plugins/CustomTranslation/angularjs/edittranslations/edittranslations.controller.js";
        $jsFiles[] = "plugins/CustomTranslation/angularjs/edittranslations/edittranslations.directive.js";
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
