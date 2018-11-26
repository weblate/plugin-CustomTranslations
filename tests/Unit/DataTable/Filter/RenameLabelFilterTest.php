<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation\tests\Unit\DataTable\Filter;

use Piwik\DataTable;
use Piwik\DataTable\Row;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * @group CustomTranslation
 * @group RenameLabelFilterTest
 * @group Plugins
 */
class RenameLabelFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataTable
     */
    private $table;

    public function setUp()
    {
        $this->table = new DataTable();
        $this->table->addRowsFromArray(array(
            array(Row::COLUMNS => array('label' => 'val1', 'nb_visits' => 120)),
            array(Row::COLUMNS => array('label' => 'val2', 'nb_visits' => 70)),
            array(Row::COLUMNS => array('label' => 'val3', 'nb_visits' => 90)),
            array(Row::COLUMNS => array('label' => 'val4', 'nb_visits' => 99)),
        ));

        $subtable1 = new DataTable();
        $subtable1->addRowsFromArray(array(
            array(Row::COLUMNS => array('label' => 'val1', 'nb_visits' => 102)),
            array(Row::COLUMNS => array('label' => 'val11', 'nb_visits' => 102)),
            array(Row::COLUMNS => array('label' => 'val12', 'nb_visits' => 29)),
            array(Row::COLUMNS => array('label' => 'val13', 'nb_visits' => 120)),
        ));

        $subtable2 = new DataTable();
        $subtable2->addRowsFromArray(array(
            array(Row::COLUMNS => array('label' => 'val2', 'nb_visits' => 0)),
            array(Row::COLUMNS => array('label' => 'val21', 'nb_visits' => 0)),
            array(Row::COLUMNS => array('label' => 'val22', 'nb_visits' => 140)),
            array(Row::COLUMNS => array('label' => 'val23', 'nb_visits' => 72)),
        ));

        $subsubtable1 = new DataTable();
        $subsubtable1->addRowsFromArray(array(
            array(Row::COLUMNS => array('label' => 'val1', 'nb_visits' => 415)),
            array(Row::COLUMNS => array('label' => 'val3', 'nb_visits' => 415)),
            array(Row::COLUMNS => array('label' => 'val31', 'nb_visits' => 415)),
            array(Row::COLUMNS => array('label' => 'val32', 'nb_visits' => 0))
        ));

        $subtable1->getRowFromLabel('val11')->setSubtable($subsubtable1);
        $this->table->getRowFromLabel('val1')->setSubtable($subtable1);
        $this->table->getRowFromLabel('val2')->setSubtable($subtable2);
    }

    public function test_filter_replaceEverywhere()
    {
        $this->filter(array('all' => array('val1' => 'newval1', 'val13' => 'newval13', 'val3' => 'newval3', 'val21' => 'newval21')));

        $this->assertEquals(array (
            0 =>
                array (
                    'label' => 'newval1',
                    'children' =>
                        array (
                                array ('label' => 'newval1',),
                                array ('label' => 'val11',
                                    'children' =>
                                        array (
                                                array ('label' => 'newval1',),
                                                array ('label' => 'newval3',),
                                                array ('label' => 'val31',),
                                                array ('label' => 'val32',),
                                        ),
                                ),
                                array ('label' => 'val12',),
                                array ('label' => 'newval13',),
                        ),
                ),
                array (
                    'label' => 'val2',
                    'children' =>
                        array (
                                array ('label' => 'val2',),
                                array ('label' => 'newval21',),
                                array ('label' => 'val22',),
                                array ('label' => 'val23',),
                        ),
                ),
                array (
                    'label' => 'newval3',
                ),
                array (
                    'label' => 'val4',
                ),
        ), $this->getLabelsNested($this->table));
    }

    public function test_filter_replaceEverywhereSomeOnlySpecificLevels()
    {
        $this->filter(array(
            'all' => array('val1' => 'newval1', 'val13' => 'newval13', 'val3' => 'newval3', 'val21' => 'newval21'),
            '1' => array('val32' => 'newval32'), // should not be replaced cause there is no such value in level1
            '2' => array('val2' => 'newval2', 'val1' => 'newval2222'), // should be replaced in level 2 but not in level 1
            '3' => array('val1' => 'newval3333'), // only replace in level 3
        ));
        $this->assertEquals(array (
                array (
                    'label' => 'newval1',
                    'children' =>
                        array (
                                array ('label' => 'newval2222',),
                                array (
                                    'label' => 'val11',
                                    'children' =>
                                        array (
                                            array ('label' => 'newval3333',),
                                            array ('label' => 'newval3',),
                                            array ('label' => 'val31',),
                                            array ('label' => 'val32',),
                                        ),
                                ),
                                array ('label' => 'val12',),
                                array ('label' => 'newval13',),
                        ),
                ),
                array (
                    'label' => 'val2',
                    'children' =>
                        array (array ('label' => 'val2',),
                                array ('label' => 'newval21',),
                                array ('label' => 'val22',),
                                array ('label' => 'val23',),
                        ),
                ),
                array ('label' => 'newval3',),
                array ('label' => 'val4',),
        ), $this->getLabelsNested($this->table));
    }

    private function getLabelsNested(DataTable $table)
    {
        $labels = array();
        foreach ($table->getRows() as $row) {
            $l = array('label' => $row->getColumn('label'));
            if ($row->getSubtable()) {
                $l['children'] = $this->getLabelsNested($row->getSubtable());
            }
            $labels[] = $l;
        }
        return $labels;
    }

    private function filter($map)
    {
        $this->table->filter('Piwik\Plugins\CustomTranslation\DataTable\Filter\RenameLabelFilter', array($map));
    }

}
