<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation\tests\System;

use Piwik\Cache;
use Piwik\Container\StaticContainer;
use Piwik\Filesystem;
use Piwik\Plugins\CustomTranslation\tests\Fixtures\CustomTranslationFixture;
use Piwik\Plugins\CustomTranslation\TranslationTypes\TranslationTypeProvider;
use Piwik\Tests\Framework\TestCase\SystemTestCase;
use Piwik\Tests\Framework\TestingEnvironmentManipulator;
use Piwik\Plugin;

/**
 * @group CustomTranslation
 * @group APITest
 * @group Plugins
 */
class APITest extends SystemTestCase
{
    /**
     * @var CustomTranslationFixture
     */
    public static $fixture = null; // initialized below class definition

    public static function setUpBeforeClass()
    {
        $pluginsToLoad = array();

        if (CustomTranslationFixture::hasCustomReports()) {
            $pluginsToLoad[] = 'CustomReports';
        }

        TestingEnvironmentManipulator::$extraPluginsToLoad = $pluginsToLoad;
        self::$fixture->extraPluginsToLoad = $pluginsToLoad;

        parent::setUpBeforeClass();

        $pluginManager = Plugin\Manager::getInstance();
        foreach ($pluginsToLoad as $extraPluginToLoad) {
            $pluginManager->loadPlugin($extraPluginToLoad);
            $pluginManager->installLoadedPlugins();
            $pluginManager->activatePlugin($extraPluginToLoad);
        }
    }

    public function test_getTranslatableTypes()
    {
        $api = 'CustomTranslation.getTranslatableTypes';
        $params = array();

        if (CustomTranslationFixture::hasCustomReports()) {
            Plugin\Manager::getInstance()->deactivatePlugin('CustomReports');
            Plugin\Manager::getInstance()->unloadPlugin('CustomReports');
            $this->clearCaches();
        }

        $this->runAnyApiTest($api, '', $params, array('testSuffix' => ''));
    }

    public function test_getTranslatableTypes_withCustomReports()
    {
        if (!CustomTranslationFixture::hasCustomReports()) {
            $this->markTestSkipped('Custom reports plugin is not available, we skip it');
            return;
        }

        $this->clearCaches();
        $env = self::$fixture->getTestEnvironment();
        $env->pluginsToLoad = array('CustomReports');
        $env->save();

        $api = 'CustomTranslation.getTranslatableTypes';
        $params = array();

        $this->runAnyApiTest($api, '', $params, array('testSuffix' => 'withCustomReports'));
    }

    private function clearCaches()
    {
        StaticContainer::get(TranslationTypeProvider::class)->clearCache();
        Cache::flushAll();
        Filesystem::deleteAllCacheOnUpdate();
    }

    public static function getOutputPrefix()
    {
        return '';
    }

    public static function getPathToTestDirectory()
    {
        return dirname(__FILE__);
    }

}

APITest::$fixture = new CustomTranslationFixture();