<?php
/**
 * InnoCraft - the company of the makers of Matomo Analytics, the free/libre analytics platform
 *
 * @link https://www.innocraft.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslation\TranslationTypes;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\DataTable\DataTableInterface;
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

    protected function translateReportLabel(DataTableInterface $dataTable, $translationMap)
    {
        // we cannot delay the filter cause it would break like `filter_pattern` (search in reports),
        // possibly pivoting etc
        $dataTable->filter('Piwik\Plugins\CustomTranslation\DataTable\Filter\RenameLabelFilter', array($translationMap));
    }
}
