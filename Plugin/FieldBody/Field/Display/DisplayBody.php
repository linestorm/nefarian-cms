<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Display;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\AbstractDisplay;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplaySettingsInterface;

class DisplayBody extends AbstractDisplay
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.text.display.html';
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
        return new DisplayBodySettings();
    }
}
