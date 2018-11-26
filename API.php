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
namespace Piwik\Plugins\CustomTranslation;

use Piwik\API\Request;
use Piwik\Piwik;
use Piwik\Plugins\CustomTranslation\Dao\TranslationsDao;
use Piwik\Plugins\CustomTranslation\TranslationTypes\TranslationType;
use Piwik\Plugins\CustomTranslation\TranslationTypes\TranslationTypeProvider;

class API extends \Piwik\Plugin\API
{
    /**
     * @var TranslationsDao
     */
    private $storage;
    /**
     * @var TranslationTypeProvider
     */
    private $provider;

    public function __construct(TranslationsDao $storage, TranslationTypeProvider $provider)
    {
        $this->storage = $storage;
        $this->provider = $provider;
    }

    public function updateTranslations($idType, $languageCode, $translations)
    {
        Piwik::checkUserHasSuperUserAccess();

        $this->provider->checkTypeExists($idType);
        $this->checkLanguageAvailable($languageCode);

        $this->storage->set($idType, $languageCode, $translations);
    }

    public function getTranslationsForType($idType, $languageCode)
    {
        Piwik::checkUserHasSuperUserAccess();

        $this->provider->checkTypeExists($idType);
        $this->checkLanguageAvailable($languageCode);

        return $this->storage->get($idType, $languageCode);
    }

    private function checkLanguageAvailable($languageCode)
    {
        $params = array('languageCode' => $languageCode);
        $languageAvailable = Request::processRequest('LanguagesManager.isLanguageAvailable', $params);

        if (!$languageAvailable) {
            throw new \Exception('Language not available');
        }
    }

    public function getTranslatableTypes()
    {
        Piwik::checkUserHasSuperUserAccess();

        $types = $this->provider->getAllTranslationTypes();
        usort($types, function ($a, $b) {
            /** @var TranslationType $a */
            /** @var TranslationType $b */
            return strcmp($a->getName(), $b->getName());
        });

        $metadata = array();
        foreach ($types as $type) {
            $metadata[] = array(
                'id' => $type->getId(),
                'name' => $type->getName(),
                'description' => $type->getDescription(),
                'translationKeys' => $type->getTranslationKeys(),
            );
        }

        return $metadata;
    }

}
