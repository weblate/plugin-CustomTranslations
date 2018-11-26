<?php
/**
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
