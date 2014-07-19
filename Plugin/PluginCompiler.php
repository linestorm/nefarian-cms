<?php

namespace Nefarian\CmsBundle\Plugin;

use Nefarian\CmsBundle\DependencyInjection\Compiler\Exception\PluginConfigNotFound;
use Symfony\Component\Yaml\Parser;

/**
 * Class PluginCompiler
 *
 * @package Nefarian\CmsBundle\Plugin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class PluginCompiler
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var string
     */
    private $path;

    /**
     * @var \ReflectionClass
     */
    private $metaClass;

    /**
     * Raw config
     *
     * @var array
     */
    private $configs;

    /**
     * @var string
     */
    private $class;

    /**
     * Routing config
     *
     * @var array
     */
    private $routing = array();

    /**
     * @param string $class
     */
    function __construct($class)
    {
        $this->class = $class;
        $this->parser = new Parser();
    }


    /**
     * Boot the plugin
     *
     * @return $this
     */
    public function compile()
    {
        $this->metaClass = new \ReflectionClass($this->class);
        $this->path = pathinfo($this->metaClass->getFileName(), PATHINFO_DIRNAME);

        $this->loadConfig();
        $this->load('menu');

        return $this;
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
    public function getCamelName()
    {
        return $this->toCamelCase($this->name);
    }

    /**
     * Get the base path
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the base namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->metaClass->getNamespaceName();
    }

    /**
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Load a yaml file
     *
     * @param $name
     * @param $file
     *
     * @return array
     */
    private function load($name, $file=null)
    {
        if(!$file)
            $file = $name.'.yml';

        $this->configs[$name] = array();

        // Read the administration routing config
        $path = $this->path . DIRECTORY_SEPARATOR . $file;
        if(file_exists($path))
        {
            return $this->configs[$name] = $this->parser->parse(file_get_contents($path));
        }

        return array();
    }

    /**
     * @throws PluginConfigNotFound
     * @return array
     */
    private function loadConfig()
    {
        $config = $this->load('module');

        if(count($config) === 0 || !array_key_exists('name', $config))
        {
            throw new PluginConfigNotFound($config);
        }

        $this->name = $config['name'];

        return $config;
    }


    /**
     * Get a config array
     *
     * @param $name
     *
     * @return array
     */
    public function getConfig($name)
    {
        if(array_key_exists($name, $this->configs))
        {
            return $this->configs[$name];
        }

        return array();
    }


    /**
     * Convert a plugin name to camel case
     *
     * @param $name
     *
     * @return mixed
     */
    private function toCamelCase($name)
    {
        $name   = preg_replace('/[^a-zA-Z0-9]/', ' ', $name);
        $string = ucwords(strtolower($name));

        return str_replace(' ', '', $string);
    }
} 
