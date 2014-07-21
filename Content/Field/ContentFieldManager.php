<?php

namespace Nefarian\CmsBundle\Content\Field;

class ContentFieldManager
{
    /**
     * @var FieldInterface[]
     */
    protected $fields;

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
        return $this->fields[$name];
    }

} 
