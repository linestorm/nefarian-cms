<?php

namespace Nefarian\CmsBundle\Configuration;


class Configuration
{

    /**
     * @var ConfigSchema[]
     */
    protected $schema;

    /**
     * @var array
     */
    protected $properties = array();

    function __construct($settings)
    {
        foreach ($settings as $key => $setting) {

            $this->schema[$key]     = new ConfigSchema($setting['type'], $setting['options']);
            $this->properties[$key] = $setting['default'];
        }
    }

    function __get($name)
    {
        return $this->get($name);
    }


    function __set($name, $value)
    {
        if ($this->has($name)) {
            $this->properties[$name] = $value;
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->properties[$name];
        }
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->properties;
    }

    /**
     * @param string $name
     * @return ConfigSchema
     */
    public function getSchema($name)
    {
        if ($this->has($name)) {
            return $this->schema[$name];
        }
    }

    /**
     * @return ConfigSchema[]
     */
    public function getAllSchemas()
    {
        return $this->schema;
    }
} 
