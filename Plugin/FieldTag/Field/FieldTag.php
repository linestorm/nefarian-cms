<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\AbstractField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplayInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetInterface;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Configuration\FieldTagConfiguration;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Display\TagHtmlDisplay;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\TagAutoCompleteWidget;

class FieldTag extends AbstractField
{
    protected $widget;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.tag';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Tag';
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
        return new FieldTagConfiguration();
    }

    /**
     * @return WidgetInterface
     */
    public function getDefaultWidget()
    {
        return new TagAutoCompleteWidget();
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
        return 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag';
    }

}
