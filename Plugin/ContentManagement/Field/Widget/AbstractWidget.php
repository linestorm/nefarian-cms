<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget;

use Nefarian\CmsBundle\Asset\AssetLibraryInterface;

/**
 * Class AbstractWidgetConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractWidget implements WidgetInterface
{
    protected $settings;

    /**
     * Get the
     *
     * @return WidgetSettingsInterface
     */
    public function getSettings()
    {
        if(!$this->settings instanceof WidgetSettingsInterface)
        {
            $this->settings = $this->getDefaultSettings();
        }

        return $this->settings;
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return null;
    }

    /**
     * @return AssetLibraryInterface[]
     */
    public function getAssetLibraries()
    {
        return array();
    }
}
