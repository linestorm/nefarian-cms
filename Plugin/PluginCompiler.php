<?php

namespace Nefarian\CmsBundle\Plugin;

use Nefarian\CmsBundle\DependencyInjection\Compiler\Exception\PluginConfigNotFound;
use Nefarian\CmsBundle\DependencyInjection\Nefarian as Configurations;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Parser;

/**
 * Class PluginCompiler
 *
 * @package Nefarian\CmsBundle\Plugin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class PluginCompiler
{
    const CONFIG_MODULE = 'module';
    const CONFIG_MENU = 'menu';
    const CONFIG_FIELDS = 'fields';
    const CONFIG_TEMPLATING = 'templating';

    /**
     * @var string
     */
    private $name;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Processor
     */
    private $processor;

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
     * @var Plugin
     */
    private $plugin;

    /**
     * @param string $class
     */
    function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * Prepare the object for serialisation
     */
    function __sleep()
    {
        // We don't want to serialise the compiler elements, so unset them
        $this->processor = null;
        $this->parser    = null;
        $this->metaClass = null;
        $this->plugin    = null;
    }

    /**
     * Boot the plugin
     *
     * @return $this
     */
    public function compile()
    {
        $this->parser    = new Parser();
        $this->processor = new Processor();

        $this->metaClass = new \ReflectionClass($this->class);
        $this->path      = pathinfo($this->metaClass->getFileName(), PATHINFO_DIRNAME);
        $this->plugin    = new $this->class();

        $this->loadModuleConfig();
        $this->loadMenuConfig();
        $this->loadFieldsConfig();
        $this->loadTemplatingConfig();

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
     * Parse a/array of config files
     *
     * @param string|array $files
     *
     * @return array
     */
    protected function parse($files)
    {
        if (!is_array($files)) {
            $files = array($files);
        }

        $configs = array();

        foreach ($files as $file) {
            if (is_file($dir = $this->path . '/' . $file)) {
                $configs[] = $this->parser->parse(file_get_contents($dir));
            }

        }

        return $configs;
    }

    /**
     * Load a yaml file
     *
     * @param string|array $configs
     * @param ConfigurationInterface $configuration
     *
     * @internal param $name
     * @return array
     */
    protected function load($configs, ConfigurationInterface $configuration)
    {
        if (!is_array($configs)) {
            $configs = array($configs);
        }

        $parsedConfigs = $this->parse($configs);

        return $this->processor->processConfiguration(
            $configuration,
            $parsedConfigs
        );
    }

    /**
     * @throws PluginConfigNotFound
     * @return array
     */
    protected function loadModuleConfig()
    {
        $this->name = $this->plugin->getName();
    }

    /**
     * @return array
     */
    protected function loadMenuConfig()
    {
        $configuration = new Configurations\MenuConfiguration();
        $config        = $this->load('Resources/config/menu.yml', $configuration);

        return $this->configs[self::CONFIG_MENU] = $config;
    }

    /**
     * @return array
     */
    protected function loadFieldsConfig()
    {
        $configuration = new Configurations\FieldsConfiguration();
        $config        = $this->load('Resources/config/content_fields.yml', $configuration);

        return $this->configs[self::CONFIG_FIELDS] = $config;
    }

    /**
     * @return array
     */
    protected function loadTemplatingConfig()
    {
        $configuration = new Configurations\TemplatingConfiguration();
        $config        = $this->load('Resources/config/templating.yml', $configuration);

        return $this->configs[self::CONFIG_TEMPLATING] = $config;
    }


    /**
     * Get a config array
     *
     * @param string $name One of the PluginCompiler::CONFIG_* constants
     *
     * @return array
     */
    public function getConfig($name)
    {
        if (array_key_exists($name, $this->configs)) {
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
    protected function toCamelCase($name)
    {
        $name   = preg_replace('/[^a-zA-Z0-9]/', ' ', $name);
        $string = ucwords(strtolower($name));

        return str_replace(' ', '', $string);
    }
} 
