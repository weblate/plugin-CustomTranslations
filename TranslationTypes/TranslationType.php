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

use Piwik\API\Request;
use Piwik\Plugins\CustomTranslation\Dao\TranslationsDao;
use Piwik\Translate;

abstract class TranslationType
{
    const ID = '';

    /**
     * @var TranslationsDao
     */
    private $storage;

    public function __construct(TranslationsDao $storage)
    {
        $this->storage = $storage;
    }

    public function getId()
    {
        if (empty(static::ID)) {
            throw new \Exception('No ID configured for ' . get_class($this));
        }
        return static::ID;
    }

    abstract public function getName();
    abstract public function getDescription();
    abstract public function translate($returnedValue, $method, $extraInfo);

    public function getTranslations()
    {
        return $this->storage->get($this->getId(), Translate::getLanguageLoaded());
    }

    public function getTranslationKeys()
    {
        return array();
    }

    protected function isRequestingAPIwithinUI($method)
    {
        if (Request::getRootApiRequestMethod() === $method) {
            if (!empty($_SERVER['HTTP_REFERER'])
                && strpos($_SERVER['HTTP_REFERER'], 'module=') !== false
                && strpos($_SERVER['HTTP_REFERER'], 'action=') !== false) {
                // the API method was requested from within the UI... in this case we usually don't want to apply
                // the renamings... but we want to apply it when the API was requested directly
                return true;
            }
        }

        return false;
    }
}
