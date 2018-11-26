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
namespace Piwik\Plugins\CustomTranslation\TranslationTypes;

use Piwik\Common;
use Piwik\Db;
use Piwik\Piwik;

class CustomDimensionEntity extends TranslationType
{
    const ID = 'customDimensionEntity';

    public function getName()
    {
        return Piwik::translate('CustomTranslation_CustomDimensionName');
    }

    public function getDescription()
    {
        return Piwik::translate('CustomTranslation_CustomDimensionDescription');
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
