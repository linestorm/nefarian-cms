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
     * @var string
     */
    protected $form;

    /**
     * @var array
     */
    protected $assets;

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
        $this->form       = $properties['form'];
        $this->assets     = $properties['assets'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getForm()
    {
        return $this->form;
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

    /**
     * @param array $assets
     */
    public function setAssets(array $assets = array())
    {
        $this->assets = $assets;
    }

    /**
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

}
