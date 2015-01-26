<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Field\Widget;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\AbstractWidget;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetSettingsInterface;
use Nefarian\CmsBundle\Plugin\FieldFile\Asset\FileDropzoneLibrary;
use Nefarian\CmsBundle\Plugin\FieldFile\Asset\TagAutoCompleteLibrary;
use Nefarian\CmsBundle\Plugin\FieldFile\Asset\TextBodyLibrary;
use Nefarian\CmsBundle\Plugin\FieldFile\Field\Widget\Form\FileDropzoneWidgetForm;

class FileDropzoneWidget extends AbstractWidget
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.file.widget.dropzone';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Dropzone Uploader';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Dropzone Uploader';
    }

    /**
     * @return WidgetSettingsInterface
     */
    protected function getDefaultSettings()
    {
        return new FileDropzoneWidgetSettings();
    }

    public function getForm()
    {
        return new FileDropzoneWidgetForm();
    }

    public function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldFile\Entity\FieldFile';
    }

    public function getAssetLibraries()
    {
        return array(
            new FileDropzoneLibrary(),
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
        return ($field->getName() === 'field.type.file');
    }

}
