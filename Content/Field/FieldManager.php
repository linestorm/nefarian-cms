<?php

namespace Nefarian\CmsBundle\Content\Field;

class FieldManager
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
        if(array_key_exists($name, $this->fields))
        {
            return $this->fields[$name];
        }

        return null;
    }

} 
