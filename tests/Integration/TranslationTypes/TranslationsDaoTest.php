<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation\tests\Integration\TranslationsTypes;

use Piwik\Plugins\CustomTranslation\TranslationTypes\DashboardEntity;
use Piwik\Plugins\CustomTranslation\TranslationTypes\TranslationTypeProvider;
use Piwik\Tests\Framework\TestCase\IntegrationTestCase;

/**
 * @group CustomTranslation
 * @group TranslationsDaoTest
 * @group Plugins
 */
class TranslationsDaoTest extends IntegrationTestCase
{
    private $typeId = 'exampleId';

    /**
     * @var TranslationTypeProvider
     */
    private $provider;

    public function setUp()
    {
        parent::setUp();

        $this->provider = new TranslationTypeProvider();
    }

    public function test_getAllTranslationTypes_findsTypes()
    {
        $types = $this->provider->getAllTranslationTypes();
        $this->assertGreaterThanOrEqual(2, count($types)); // number depends on installed plugins
    }

    public function test_getAllTranslationTypes_indexedById()
    {
        $types = $this->provider->getAllTranslationTypes();

        $this->assertArrayHasKey(DashboardEntity::ID, $types);
        foreach ($types as $typeId => $type) {
            $this->assertSame($typeId, $type->getId());
        }
    }

    public function test_checkTypeExists_validId()
    {
        $this->provider->checkTypeExists(DashboardEntity::ID);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage General_ValidatorErrorXNotWhitelisted
     */
    public function test_checkTypeExists_invalidId()
    {
        $this->provider->checkTypeExists('foo');
    }

}
