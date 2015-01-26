<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Field;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\AbstractField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplayInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetInterface;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Configuration\FieldBodyConfiguration;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Display\DisplayBody;
use Nefarian\CmsBundle\Plugin\FieldBody\Field\Widget\WidgetBody;

class FieldBody extends AbstractField
{
    protected $widget;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field.type.text';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Text';
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
        return new FieldBodyConfiguration();
    }

    /**
     * @return WidgetInterface
     */
    public function getDefaultWidget()
    {
        return new WidgetBody();
    }

    /**
     * @return DisplayInterface
     */
    public function getDefaultDisplay()
    {
        return new DisplayBody();
    }

    /**
     * Get the entity class name for this field
     *
     * @return string
     */
    public function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldBody\Entity\FieldBody';
    }
}
