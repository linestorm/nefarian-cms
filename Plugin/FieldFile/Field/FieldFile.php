<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Field;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\AbstractField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplayInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetInterface;
use Nefarian\CmsBundle\Plugin\FieldFile\Field\Configuration\FieldFileConfiguration;
use Nefarian\CmsBundle\Plugin\FieldFile\Field\Display\TagHtmlDisplay;
use Nefarian\CmsBundle\Plugin\FieldFile\Field\Widget\FileDropzoneWidget;
use Nefarian\CmsBundle\Plugin\FieldFile\Field\Widget\TagAutoCompleteWidget;

class FieldFile extends AbstractField
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.file';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'File';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings()
    {
        return new FieldFileConfiguration();
    }

    /**
     * @return WidgetInterface
     */
    public function getDefaultWidget()
    {
        return new FileDropzoneWidget();
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new TagHtmlDisplay();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldFile\Entity\FieldFile';
    }

}
