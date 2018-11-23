<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\CustomTranslations\TranslationTypes;
use Piwik\Container\StaticContainer;
use Piwik\Plugins\CustomTranslations\Dao\CustomTranslationStorage;
use Piwik\Translate;

abstract class TranslationType
{
    const ID = '';

    /**
     * @var CustomTranslationStorage
     */
    private $storage;

    public function __construct(CustomTranslationStorage $storage)
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

    public function getSuggestedValues()
    {
        return array();
    }

    /**
     * @return TranslationType[]
     */
    public static function getAllTranslationTypes()
    {
        return [
            StaticContainer::get(CustomDimensionEntity::class),
            StaticContainer::get(CustomDimensionLabel::class),
            StaticContainer::get(CustomReportEntity::class),
            StaticContainer::get(DashboardEntity::class),
            StaticContainer::get(EventLabel::class),
        ];
    }
}
