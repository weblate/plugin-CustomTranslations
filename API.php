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
use Piwik\Plugins\CustomTranslations\Dao\CustomTranslationStorage;
use Piwik\Plugins\CustomTranslations\TranslationTypes\TranslationType;

/**
 * API for plugin CustomTranslations
 *
 * @method static \Piwik\Plugins\CustomTranslations\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    private $storage;

    public function __construct(CustomTranslationStorage $storage)
    {
        $this->storage = $storage;
    }

    public function updateTranslations($type, $language, $translations)
    {
        Piwik::checkUserHasSuperUserAccess();

        $this->storage->set($type, $language, $translations);
    }

    public function getTranslatableTypes()
    {
        Piwik::checkUserHasSuperUserAccess();

        $types = array();
        foreach (TranslationType::getAllTranslationTypes() as $type) {
            $types[] = array(
                'id' => $type->getId(),
                'name' => $type->getName(),
                'description' => $type->getDescription(),
                'suggestedValues' => $type->getSuggestedValues(),
            );
        }

        return $types;
    }

    public function getTranslationsForType($type, $language)
    {
        Piwik::checkUserHasSuperUserAccess();

        return $this->storage->get($type, $language);
    }
}
