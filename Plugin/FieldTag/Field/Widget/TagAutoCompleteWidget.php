<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\AbstractWidget;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Nefarian\CmsBundle\Plugin\FieldTag\Asset\TagAutoCompleteLibrary;
use Nefarian\CmsBundle\Plugin\FieldTag\Asset\TextBodyLibrary;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form\TagAutoCompleteWidgetForm;
use Nefarian\CmsBundle\Plugin\FieldTag\Form\FieldTagForm;

class TagAutoCompleteWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag.widget.autocomplete';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Auto Complete Tag Selector';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Tags Using Auto Complete';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new TagAutoCompleteWidgetSettings();
    }

    public function getForm()
    {
        return 'nefarian_plugin_field_tag_widget_autocomplete';
    }

    public function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag';
    }

    public function getAssetLibraries()
    {
        return array(
            new TagAutoCompleteLibrary(),
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
        return ($field->getName() === 'field.type.tag');
    }

}
