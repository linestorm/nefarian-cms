<?php

namespace Nefarian\CmsBundle\Content\Field;

class Field implements FieldInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @param string $name
     * @param array  $properties
     */
    function __construct($name, array $properties = array())
    {
        $this->name       = $name;
        $this->class      = $properties['class'];
        $this->properties = $properties['properties'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getProperty($name)
    {
        if(array_key_exists($name, $this->properties))
        {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * Returns the entity class
     *
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->class;
    }


}
