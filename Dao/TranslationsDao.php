<?php

/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations\Dao;

use Piwik\Option;

class TranslationsDao
{
    public const OPTION_LANG_PREFIX = 'CustomTranslations_lang_';
    private const ALLOWED_HTML_TAG_PATTERN = '/^<\s*(?:\/\s*(?:b|strong|i|em)|(?:b|strong|i|em)|br\s*\/?)\s*>$/i';

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

            $this->validateTranslationValues($values);
            Option::set($this->makeId($typeId, $lang), json_encode($values));
        }
    }

    private function validateTranslationValues(array $values)
    {
        foreach ($values as $value) {
            if (!is_string($value) || strpos($value, '<') === false) {
                continue;
            }

            $this->validateAllowedHtml($value);
        }
    }

    private function validateAllowedHtml($value)
    {
        if (preg_match_all('/<\s*\/?\s*[a-zA-Z][^>]*>/', $value, $matches)) {
            foreach ($matches[0] as $tag) {
                if (!preg_match(self::ALLOWED_HTML_TAG_PATTERN, $tag)) {
                    if (preg_match('/^<\s*\/?\s*(b|strong|i|em|br)\b/i', $tag)) {
                        throw new \Exception('Translation values cannot contain HTML attributes.');
                    }

                    throw new \Exception('Translation values can only contain a small set of formatting tags.');
                }
            }
        }

        if (preg_match('/<\s*!|<\s*\?/', $value)) {
            if (preg_match('/<\s*(?:!--|\!DOCTYPE|\!\[CDATA\[|\?xml|\?php)/i', $value)) {
                throw new \Exception('Translation values can only contain a small set of formatting tags.');
            }
        }
    }

    private function makeId($typeId, $lang)
    {
        return sprintf('CustomTranslations_lang_%s_%s', $typeId, $lang);
    }
}
