<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation;

use Piwik\Piwik;

class Controller extends \Piwik\Plugin\ControllerAdmin
{
    public function manage()
    {
        Piwik::checkUserHasSuperUserAccess();
        return $this->renderTemplate('manage');
    }
}
