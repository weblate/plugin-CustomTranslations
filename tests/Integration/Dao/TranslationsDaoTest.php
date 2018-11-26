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
namespace Piwik\Plugins\CustomTranslation\tests\Integration;

use Piwik\Plugins\CustomTranslation\Dao\TranslationsDao;
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
     * @var TranslationsDao
     */
    private $dao;

    public function setUp()
    {
        parent::setUp();

        $this->dao = new TranslationsDao();
        $this->dao->set($this->typeId, 'en', array('foo' => 'bar', 'baz' => 'buzz'));
    }

    public function test_get_returnsEmptyArrayWhenNoValueStored()
    {
        $translations = $this->dao->get('foo', 'en');
        $this->assertSame(array(), $translations);

        $translations = $this->dao->get($this->typeId, 'nz');
        $this->assertSame(array(), $translations);
    }

    public function test_get_returnsStoredValue()
    {
        $translations = $this->dao->get($this->typeId, 'en');
        $this->assertSame(array('foo' => 'bar', 'baz' => 'buzz'), $translations);
    }

    public function test_set_canStoreAnyKindOfKey()
    {
        $example = array('こんにちは.?#2!\'/<">' => 'bar');
        $this->dao->set($this->typeId, 'nz', $example);
        $translations = $this->dao->get($this->typeId, 'nz');
        $this->assertSame($example, $translations);
    }

    public function test_set_differentTypesAndLanguagesDifferentStorages()
    {
        $nz = array('nz1' => 'nz2');
        $de = array('de1' => 'de2');
        $de2 = array('de10' => 'de20');
        $this->dao->set($this->typeId, 'nz', $nz);
        $this->dao->set($this->typeId, 'de', $de);
        $this->dao->set('type2', 'de', $de2);

        $this->assertSame($nz, $this->dao->get($this->typeId, 'nz'));
        $this->assertSame($de, $this->dao->get($this->typeId, 'de'));
        $this->assertSame($de2, $this->dao->get('type2', 'de'));
    }

}
