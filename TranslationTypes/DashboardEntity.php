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
namespace Piwik\Plugins\CustomTranslations\TranslationTypes;

class DashboardEntity extends TranslationType
{
    const ID = 'dashboardEntity';

    public function getName()
    {
        return 'Dashboard Entity';
    }

    public function getDescription()
    {
        return 'Translates the name of dashboard entities';
    }

    public function translate($returnedValue, $method, $extraInfo)
    {
        if ($method === 'Dashboard.getDashboards' && is_array($returnedValue)) {
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
