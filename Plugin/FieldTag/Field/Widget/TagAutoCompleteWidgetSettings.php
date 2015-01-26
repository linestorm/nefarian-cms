<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget;

use Nefarian\CmsBundle\Configuration\AbstractConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form\TagAutoCompleteWidgetSettingsForm;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form\WidgetBodySettingsForm;

/**
 * Class TagAutoCompleteWidgetSettings
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetSettings extends AbstractConfiguration implements WidgetSettingsInterface
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
        return 'field.type.text.widget.editor.settings';
    }

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm()
    {
        return new TagAutoCompleteWidgetSettingsForm();
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
