<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display;

/**
 * Class AbstractDisplay
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractDisplay implements DisplayInterface
{
    protected $settings;

    /**
     * Get the
     *
     * @return DisplaySettingsInterface
     */
    public function getSettings()
    {
        if(!$this->settings instanceof DisplaySettingsInterface)
        {
            $this->settings = $this->getDefaultSettings();
        }

        return $this->settings;
    }

    /**
     * @return DisplaySettingsInterface
     */
    abstract protected function getDefaultSettings();
}
