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

    public function setUp(): void
    {
        parent::setUp();

        $this->api = API::getInstance();
        $this->theFixture = new CustomTranslationsFixture();
    }

    public function test_setTranslations_requiresSuperUserAccess()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('checkUserHasSuperUserAccess');
        $this->setAdminUser();
        $this->api->setTranslations('foo', 'bar', array('baz' => 'bazz'));
    }

    public function test_setTranslations_validatesType()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('CustomTranslations_TranslationType: General_ValidatorErrorXNotWhitelisted');
        $this->api->setTranslations('invalidtype', 'en', array('baz' => 'bazz'));
    }

    public function test_setTranslations_validatesLanguage()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid language code');
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

    public function test_getTranslatableTypes_requiresSuperUserAccess()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('checkUserHasSuperUserAccess');
        $this->setAdminUser();
        $this->api->getTranslatableTypes();
    }

    public function test_getTranslationsForType_requiresSuperUserAccess()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('checkUserHasSuperUserAccess');
        $this->setAdminUser();
        $this->api->getTranslationsForType('foo', 'bar');
    }

    public function test_getTranslationsForType_validatesType()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('CustomTranslations_TranslationType: General_ValidatorErrorXNotWhitelisted');
        $this->api->getTranslationsForType('invalidtype', 'en');
    }

    public function test_getTranslationsForType_validatesLanguage()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid language code');
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
