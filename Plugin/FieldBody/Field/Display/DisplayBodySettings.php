<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Display;

use Nefarian\CmsBundle\Configuration\AbstractConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplaySettingsInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Display\Form\DisplayBodySettingsForm;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\Form\WidgetBodySettingsForm;

/**
 * Class DisplayBodySettings
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class DisplayBodySettings extends AbstractConfiguration implements DisplaySettingsInterface
{
    /**
     * @var bool
     */
    protected $useEditor = true;

    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType()
    {
        return 'field.type.text.display.html.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new DisplayBodySettingsForm();
    }

    /**
     * @return boolean
     */
    public function getUseEditor()
    {
        return $this->useEditor;
    }

    /**
     * @param boolean $useEditor
     */
    public function setUseEditor($useEditor)
    {
        $this->useEditor = $useEditor;
    }



}
