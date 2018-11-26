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
namespace Piwik\Plugins\CustomTranslation\tests\Fixtures;

use Piwik\API\Request;
use Piwik\Date;
use Piwik\Plugins\CustomTranslation\API;
use Piwik\Plugins\CustomTranslation\TranslationTypes\DashboardEntity;
use Piwik\Tests\Framework\Fixture;

class CustomTranslationFixture extends Fixture
{
    public $dateTime = '2013-01-23 01:23:45';
    public $idSite = 1;
    public $idSite2 = 2;

    public function setUp()
    {
        Fixture::createSuperUser();

        $this->setUpWebsite();
        $this->trackFirstVisit();
        $this->setTranslations();
        $this->createDashboards();
        $this->createCustomDimensions();
        $this->createCustomReports();
    }

    public function tearDown()
    {
        // empty
    }

    private function setUpWebsite()
    {
        foreach (array($this->idSite, $this->idSite2) as $idSite) {
            if (!self::siteCreated($idSite)) {
                $idSiteCreated = self::createWebsite($this->dateTime, $ecommerce = 1);
                $this->assertSame($idSite, $idSiteCreated);
            }
        }
    }

    private function createDashboards()
    {
        foreach (array(Fixture::ADMIN_USER_LOGIN, 'foouser', 'baruser') as $login) {
            Request::processRequest('Dashboard.createNewDashboardForUser', array(
                'login' => $login, 'dashboardName' => 'Dashboard1',
            ));
            Request::processRequest('Dashboard.createNewDashboardForUser', array(
                'login' => $login, 'dashboardName' => 'Dashboard2',
            ));
            Request::processRequest('Dashboard.createNewDashboardForUser', array(
                'login' => $login, 'dashboardName' => 'Dashboard3',
            ));
        }
    }

    private function createCustomReports()
    {
        if (!self::hasCustomReports()) {
            return;
        }
        foreach (array($this->idSite, $this->idSite2) as $idSite) {
            $this->addCustomReport($idSite, 'CustomReport1');
            $this->addCustomReport($idSite, 'CustomReport2');
            $this->addCustomReport($idSite, 'CustomReport3');
        }
    }

    private function addCustomReport($idSite, $name)
    {
        return Request::processRequest('CustomReports.addCustomReport', array(
            'idSite' => $idSite, 'name' => $name, 'reportType' => 'evolution', 'metricIds' => array('nb_visits')
        ));
    }

    private function createCustomDimensions()
    {
        foreach (array($this->idSite, $this->idSite2) as $idSite) {
            Request::processRequest('CustomDimensions.configureNewCustomDimension', array(
                'idSite' => $idSite, 'name' => 'DimensionVisit1', 'scope' => 'visit', 'active' => '1'
            ));
            Request::processRequest('CustomDimensions.configureNewCustomDimension', array(
                'idSite' => $idSite, 'name' => 'DimensionVisit2', 'scope' => 'visit', 'active' => '1'
            ));
            Request::processRequest('CustomDimensions.configureNewCustomDimension', array(
                'idSite' => $idSite, 'name' => 'DimensionAction1', 'scope' => 'action', 'active' => '1'
            ));
            Request::processRequest('CustomDimensions.configureNewCustomDimension', array(
                'idSite' => $idSite, 'name' => 'DimensionAction2', 'scope' => 'action', 'active' => '1'
            ));
        }
    }

    private function setTranslations()
    {
        API::getInstance()->updateTranslations(DashboardEntity::ID, 'de', array(
            'Dashboard' => 'BoardDash',
            'ecommerce' => 'Shop'
        ));
    }

    protected function trackFirstVisit()
    {
        $t = self::getTracker($this->idSite, $this->dateTime, $defaultInit = true);

        $t->setForceVisitDateTime(Date::factory($this->dateTime)->addHour(0.1)->getDatetime());
        $t->setUrl('http://example.com/');
        self::checkResponse($t->doTrackPageView('Viewing homepage'));

        $t->setForceVisitDateTime(Date::factory($this->dateTime)->addHour(0.2)->getDatetime());
        $t->setUrl('http://example.com/sub/page');
        self::checkResponse($t->doTrackPageView('Second page view'));

        $t->setForceVisitDateTime(Date::factory($this->dateTime)->addHour(0.25)->getDatetime());
        $t->addEcommerceItem($sku = 'SKU_ID', $name = 'Test item!', $category = 'Test & Category', $price = 777, $quantity = 33);
        self::checkResponse($t->doTrackEcommerceOrder('TestingOrder', $grandTotal = 33 * 77));
    }

    public static function hasCustomReports()
    {
        return file_exists(PIWIK_DOCUMENT_ROOT . '/plugins/CustomReports/CustomReports.php');
    }

}