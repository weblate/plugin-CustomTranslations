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

class CustomDimensionEntity extends TranslationType
{
    const ID = 'customDimensionEntity';

    public function getName()
    {
        return Piwik::translate('CustomTranslations_CustomDimensionName');
    }

    public function getDescription()
    {
        return Piwik::translate('CustomTranslations_CustomDimensionDescription');
    }

    public function getTranslationKeys()
    {
        $rows = Db::fetchAll('SELECT DISTINCT `name` from ' . Common::prefixTable('custom_dimensions') . ' where active = 1');
        return array_filter(array_unique(array_column($rows, 'name')));
    }

    public function translate($returnedValue, $method, $extraInfo)
    {
        if ($method === 'CustomDimensions.getConfiguredCustomDimensions'
            && is_array($returnedValue)) {

            if ($this->isRequestingAPIwithinUI('CustomDimensions.getConfiguredCustomDimensions')) {
                // make sure in manage custom dimensions the correct names are shown
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
