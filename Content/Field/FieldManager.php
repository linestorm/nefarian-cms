<?php

namespace Nefarian\CmsBundle\Content\Field;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplayInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetInterface;

class FieldManager
{
    /**
     * @var FieldInterface[]
     */
    protected $fields = array();

    /**
     * @var DisplayInterface[]
     */
    protected $fieldDisplays = array();

    /**
     * @var WidgetInterface[]
     */
    protected $fieldWidgets = array();

    /**
     * Add a field to the manager
     *
     * @param FieldInterface $field
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[$field->getName()] = $field;
    }

    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $name
     *
     * @return FieldInterface
     */
    public function getField($name)
    {
        if(array_key_exists($name, $this->fields))
        {
            return $this->fields[$name];
        }

        return null;
    }

    /**
     * Add a field widget to the manager
     *
     * @param WidgetInterface $widget
     */
    public function addFieldWidget(WidgetInterface $widget)
    {
        $this->fieldWidgets[$widget->getName()] = $widget;
    }

    /**
     * @return WidgetInterface[]
     */
    public function getFieldWidgets()
    {
        return $this->fieldWidgets;
    }

    /**
     * @param $name
     *
     * @return WidgetInterface
     */
    public function getFieldWidget($name)
    {
        if(array_key_exists($name, $this->fieldWidgets))
        {
            return $this->fieldWidgets[$name];
        }

        return null;
    }

    /**
     * Add a field widget to the manager
     *
     * @param DisplayInterface $widget
     */
    public function addFieldDisplay(DisplayInterface $widget)
    {
        $this->fieldDisplays[$widget->getName()] = $widget;
    }

    /**
     * @return DisplayInterface[]
     */
    public function getFieldDisplays()
    {
        return $this->fieldDisplays;
    }

    /**
     * @param $name
     *
     * @return DisplayInterface
     */
    public function getFieldDisplay($name)
    {
        if(array_key_exists($name, $this->fieldDisplays))
        {
            return $this->fieldDisplays[$name];
        }

        return null;
    }

} 
