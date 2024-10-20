<?php

/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations\TranslationTypes;

use Piwik\DataTable\DataTableInterface;
use Piwik\Piwik;

class CustomDimensionLabel extends TranslationType
{
    public const ID = 'customDimensionLabel';

    public function getName()
    {
        return Piwik::translate('CustomTranslations_CustomDimensionValue');
    }

    public function getDescription()
    {
        return Piwik::translate('CustomTranslations_CustomDimensionValueDescription');
    }

    public function getTranslationKeys()
    {
        return [];
    }

    public function translate($returnedValue, $method, $extraInfo)
    {
        if ($method === 'CustomDimensions.getCustomDimension' && $returnedValue instanceof DataTableInterface) {
            $renameMap = array('all' => $this->getTranslations());
            $this->translateReportLabel($returnedValue, $renameMap);
        }
        return $returnedValue;
    }
}
