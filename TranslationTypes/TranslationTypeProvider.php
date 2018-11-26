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

use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\Plugin\Manager;
use Piwik\Validators\BaseValidator;
use Piwik\Validators\WhitelistedValue;

class TranslationTypeProvider
{
    private $instances = [];

    public function checkTypeExists($idType)
    {
        $types = array_keys($this->getAllTranslationTypes());
        $params = [new WhitelistedValue($types)];
        BaseValidator::check(Piwik::translate('CustomTranslation_TranslationType'), $idType, $params);
    }

    /**
     * @ignore
     * @internal  tests only
     */
    public function clearCache()
    {
        $this->instances = [];
    }

    /**
     * @return TranslationType[]
     */
    public function getAllTranslationTypes()
    {
        if (empty($this->instances)) {
            $pluginManager = Manager::getInstance();
            $typeClassNames = $pluginManager->findMultipleComponents('TranslationTypes', TranslationType::class);

            foreach ($typeClassNames as $typeClassName) {
                $type = StaticContainer::getContainer()->make($typeClassName);
                $this->instances[$type->getId()] = $type;
            }

            if (!$pluginManager->isPluginActivated('CustomReports')) {
                // ideally we would move CustomReportEntity to the custom reports plugin, but this way it will be easier
                // testable for now as it needs to integrate with customdimensions and events etc
                // also for now we don't move dashboard entity to dashboards plugin etc
                unset($this->instances[CustomReportEntity::ID]);
            }
        }

        return $this->instances;
    }
}
