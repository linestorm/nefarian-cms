<?php

namespace Nefarian\CmsBundle\Configuration;


class Configuration {

    /**
     * @var array
     */
    protected $properties = array();

    function __construct($properties)
    {
        $this->properties = $properties;
    }

    function __get($name)
    {
        return $this->get($name);
    }


    function __set($name, $value)
    {
        if($this->has($name))
        {
            $this->properties[$name] = $value;
        }
    }


    public function has($name)
    {
        return isset($this->properties[$name]);
    }


    public function get($name)
    {
        if($this->has($name))
        {
            return $this->properties[$name];
        }
    }

    public function getAll()
    {
        return $this->properties;
    }

} 
