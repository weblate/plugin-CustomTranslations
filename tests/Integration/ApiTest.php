<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations\tests\Integration;

use Piwik\Plugins\CustomTranslations\API;
use Piwik\Plugins\CustomTranslations\tests\Fixtures\CustomTranslationsFixture;
use Piwik\Plugins\CustomTranslations\TranslationTypes\DashboardEntity;
use Piwik\Plugins\CustomTranslations\TranslationTypes\EventLabel;
use Piwik\Tests\Framework\Mock\FakeAccess;
use Piwik\Tests\Framework\TestCase\IntegrationTestCase;

/**
 * @group CustomTranslations
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
     * @var CustomTranslationsFixture
     */
    private $theFixture;

    public function setUp()
    {
        parent::setUp();

        $this->api = API::getInstance();
        $this->theFixture = new CustomTranslationsFixture();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage checkUserHasSuperUserAccess
     */
    public function test_setTranslations_requiresSuperUserAccess()
    {
        $this->setAdminUser();
        $this->api->setTranslations('foo', 'bar', array('baz' => 'bazz'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessageCustomTranslations_TranslationType: General_ValidatorErrorXNotWhitelisted
     */
    public function test_setTranslations_validatesType()
    {
        $this->api->setTranslations('invalidtype', 'en', array('baz' => 'bazz'));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid language code
     */
    public function test_setTranslations_validatesLanguage()
    {
        $this->api->setTranslations(DashboardEntity::ID, 'fp', array('baz' => 'bazz'));
    }

    public function test_setTranslations_success()
    {
        $this->api->setTranslations(DashboardEntity::ID, 'en', array('baz' => 'bazz'));
        $this->api->setTranslations(DashboardEntity::ID, 'fr', array('foo' => 'bar'));
        $this->api->setTranslations(EventLabel::ID, 'fr', array('bar' => 'baz'));

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
     * @expectedExceptionMessageCustomTranslations_TranslationType: General_ValidatorErrorXNotWhitelisted
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
