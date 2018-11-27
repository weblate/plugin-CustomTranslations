<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation\tests\Integration;

use Piwik\Plugins\CustomTranslation\API;
use Piwik\Plugins\CustomTranslation\tests\Fixtures\CustomTranslationFixture;
use Piwik\Plugins\CustomTranslation\TranslationTypes\DashboardEntity;
use Piwik\Plugins\CustomTranslation\TranslationTypes\EventLabel;
use Piwik\Plugins\CustomTranslation\TranslationTypes\TranslationTypeProvider;
use Piwik\Tests\Framework\Mock\FakeAccess;
use Piwik\Tests\Framework\TestCase\IntegrationTestCase;

/**
 * @group CustomTranslation
 * @group TranslationsDaoTest
 * @group Plugins
 */
class ApiTest extends IntegrationTestCase
{
    /**
     * @var int
     */
    private $idSite;

    /**
     * @var API
     */
    private $api;

    /**
     * @var CustomTranslationFixture
     */
    private $theFixture;

    public function setUp()
    {
        parent::setUp();

        $this->api = API::getInstance();
        $this->theFixture = new CustomTranslationFixture();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage checkUserHasSuperUserAccess
     */
    public function test_updateTranslations_requiresSuperUserAccess()
    {
        $this->setAdminUser();
        $this->api->updateTranslations('foo', 'bar', array('baz' => 'bazz'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessageCustomTranslation_TranslationType: General_ValidatorErrorXNotWhitelisted
     */
    public function test_updateTranslations_validatesType()
    {
        $this->api->updateTranslations('invalidtype', 'en', array('baz' => 'bazz'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid language code
     */
    public function test_updateTranslations_validatesLanguage()
    {
        $this->api->updateTranslations(DashboardEntity::ID, 'fp', array('baz' => 'bazz'));
    }

    public function test_updateTranslations_success()
    {
        $this->api->updateTranslations(DashboardEntity::ID, 'en', array('baz' => 'bazz'));
        $this->api->updateTranslations(DashboardEntity::ID, 'fr', array('foo' => 'bar'));
        $this->api->updateTranslations(EventLabel::ID, 'fr', array('bar' => 'baz'));

        $values = $this->api->getTranslationsForType(DashboardEntity::ID, 'en');
        $this->assertSame(array('baz' => 'bazz'), $values);
        $values = $this->api->getTranslationsForType(DashboardEntity::ID, 'fr');
        $this->assertSame(array('foo' => 'bar'), $values);
        $values = $this->api->getTranslationsForType(EventLabel::ID, 'fr');
        $this->assertSame(array('bar' => 'baz'), $values);
        $this->assertSame(array(), $this->api->getTranslationsForType(EventLabel::ID, 'de'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage checkUserHasSuperUserAccess
     */
    public function test_getTranslatableTypes_requiresSuperUserAccess()
    {
        $this->setAdminUser();
        $this->api->getTranslatableTypes();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage checkUserHasSuperUserAccess
     */
    public function test_getTranslationsForType_requiresSuperUserAccess()
    {
        $this->setAdminUser();
        $this->api->getTranslationsForType('foo', 'bar');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessageCustomTranslation_TranslationType: General_ValidatorErrorXNotWhitelisted
     */
    public function test_getTranslationsForType_validatesType()
    {
        $this->api->getTranslationsForType('invalidtype', 'en');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid language code
     */
    public function test_getTranslationsForType_validatesLanguage()
    {
        $this->api->getTranslationsForType(DashboardEntity::ID, 'fp');
    }

    protected function setAdminUser()
    {
        FakeAccess::clearAccess(false);
        FakeAccess::$identity = 'testUser';
        FakeAccess::$idSitesView = array();
        FakeAccess::$idSitesAdmin = array(1,3, $this->idSite);
    }

    public function provideContainerConfig()
    {
        return array(
            'Piwik\Access' => new FakeAccess()
        );
    }
}
