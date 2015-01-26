<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Field\Display;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\AbstractDisplay;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplaySettingsInterface;

/**
 * Class TagHtmlDisplay
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Field\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagHtmlDisplay extends AbstractDisplay
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag.display.html';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Full HTML output';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'HTML rendered output';
    }

    /**
     * @return DisplaySettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new TagHtmlDisplaySettings();
    }
}
