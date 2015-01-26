<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Display;

use Nefarian\CmsBundle\Configuration\AbstractConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplaySettingsInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Display\Form\DisplayBodySettingsForm;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Display\Form\TagHtmlDisplaySettingsForm;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form\WidgetBodySettingsForm;

/**
 * Class TagHtmlDisplaySettings
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Field\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagHtmlDisplaySettings extends AbstractConfiguration implements DisplaySettingsInterface
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
        return 'field.type.tag.display.html.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new TagHtmlDisplaySettingsForm();
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
