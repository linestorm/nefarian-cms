<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\AbstractWidget;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Nefarian\CmsBundle\Plugin\FieldBody\Asset\TextBodyLibrary;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\Form\WidgetBodyForm;

/**
 * Class WidgetBody
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class WidgetBody extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.text.widget.editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Text Editor';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'WYSIWYG editor for text field';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new WidgetBodySettings();
    }

    public function getForm()
    {
        return new WidgetBodyForm();
    }

    public function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldBody\Entity\FieldBody';
    }

    public function getAssetLibraries()
    {
        return array(
            new TextBodyLibrary(),
        );
    }

    /**
     * Checks if this widget supports the given field
     *
     * @param FieldInterface $field
     *
     * @return string
     */
    public function supportsField(FieldInterface $field)
    {
        return ($field->getName() === 'field.type.text');
    }

}
