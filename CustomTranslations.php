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
namespace Piwik\Plugins\CustomTranslations;

use Piwik\Piwik;
use Piwik\Plugins\CustomTranslations\TranslationTypes\TranslationType;

class CustomTranslations extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'API.Request.dispatch.end' => 'updateEvents'
        );
    }

    public function updateEvents(&$returnedValue, $extraInfo)
    {
        if (empty($extraInfo['module']) || empty($extraInfo['action'])) {
            return;
        }

        if (!Piwik::isUserHasSomeViewAccess()) {
            return;
        }

        $module = $extraInfo['module'];
        $action = $extraInfo['action'];
        $method = $module . '.' . $action;

        foreach (TranslationType::getAllTranslationTypes() as $type) {
            $returnedValue = $type->translate($returnedValue, $method, $extraInfo);
        }
    }

}
