<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations\TranslationTypes;

use Piwik\Common;
use Piwik\Db;
use Piwik\Piwik;

class DashboardEntity extends TranslationType
{
    const ID = 'dashboardEntity';

    public function getName()
    {
        return Piwik::translate('CustomTranslations_DashboardName');
    }

    public function getDescription()
    {
        return Piwik::translate('CustomTranslations_DashboardDescription');
    }

    public function getTranslationKeys()
    {
        $rows = Db::fetchAll('SELECT DISTINCT `name` from ' . Common::prefixTable('user_dashboard'));
        return array_filter(array_unique(array_column($rows, 'name')));
    }

    public function translate($returnedValue, $method, $extraInfo)
    {
        if ($method === 'Dashboard.getDashboards' && is_array($returnedValue)) {

            if ($this->isRequestingAPIwithinUI('Dashboard.getDashboards')) {
                // we make sure that when using renaming Dashboard feature, to show the original dashboard name, and also
                // that when moving around a dashboard, to keep the original name
                return $returnedValue;
            }

            $translations = $this->getTranslations();
            foreach ($returnedValue as &$value) {
                if (isset($translations[$value['name']])) {
                    $value['name'] = $translations[$value['name']];
                }
            }
        }
        return $returnedValue;
    }

}
