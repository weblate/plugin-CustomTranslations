<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
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
        }

        return $translations;
    }

    public function set($typeId, $lang, $values)
    {
        if (empty($values)) {
            Option::delete($this->makeId($typeId, $lang));
        } else {
            if (!is_array($values)) {
                throw new \Exception('$translations needs to be an array');
            }

            Option::set($this->makeId($typeId, $lang), json_encode($values));
        }
    }

    private function makeId($typeId, $lang)
    {
        return sprintf('CustomTranslation_lang_%s_%s', $typeId, $lang);
    }
}
