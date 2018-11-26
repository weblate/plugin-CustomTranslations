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
namespace Piwik\Plugins\CustomTranslation\Dao;

use Piwik\Option;

class TranslationsDao
{
    CONST OPTION_LANG_PREFIX = 'CustomTranslation_lang_';

    public function get($typeId, $lang)
    {
        $translations = Option::get($this->makeId($typeId, $lang));
        if (!empty($translations)) {
            $translations = json_decode($translations, true);
        }
        if (empty($translations) || !is_array($translations)) {
            $translations = array();
        } else {
            $translations = array_filter($translations);
        }
        return $translations;
    }

    public function set($typeId, $lang, $values)
    {
        $values = json_encode($values);
        Option::set($this->makeId($typeId, $lang), $values);
    }

    private function makeId($typeId, $lang)
    {
        return sprintf('CustomTranslation_lang_%s_%s', $typeId, $lang);
    }
}
