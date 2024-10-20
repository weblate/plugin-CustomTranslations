<?php

/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations;

use Piwik\Menu\MenuAdmin;
use Piwik\Piwik;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureAdminMenu(MenuAdmin $menu)
    {
        if (Piwik::hasUserSuperUserAccess()) {
            $menu->addSystemItem('CustomTranslations_CustomTranslations', $this->urlForAction('manage'));
        }
    }
}
