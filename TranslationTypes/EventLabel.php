<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation\TranslationTypes;

use Piwik\DataTable\DataTableInterface;
use Piwik\Piwik;

class EventLabel extends TranslationType
{
    const ID = 'eventLabel';

    public function getName()
    {
        return Piwik::translate('CustomTranslation_EventValue');
    }

    public function getDescription()
    {
        return Piwik::translate('CustomTranslation_EventValueDescription');
    }

    public function getTranslationKeys()
    {
        return [];
    }

    public function translate($returnedValue, $method, $extraInfo)
    {
        if (strpos($method, 'Events.') === 0 && $returnedValue instanceof DataTableInterface) {
            $renameMap = array('all' => $this->getTranslations());
            $this->translateReportLabel($returnedValue, $renameMap);
        }
        return $returnedValue;
    }

}
