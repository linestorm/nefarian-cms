<?php

namespace Nefarian\CmsBundle\Plugin;

/**
 * Class Plugin
 *
 * @package Nefarian\CmsBundle\Plugin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class Plugin
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var \ReflectionClass
     */
    private $meta;

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * initialiser
     */
    function __construct()
    {
        $this->meta = new \ReflectionClass($this);
        $this->path = pathinfo($this->meta->getFileName(), PATHINFO_DIRNAME);
        $this->namespace = $this->meta->getNamespaceName();
    }

    /**
     * @return string
     */
    abstract public function getName();

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
        return $this->namespace;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Return an array of plugins names that this plugin requires
     *
     * If you need logic to determine dependencies, throw a PluginDependencyNotInstalledException if it fails
     */
    public function dependencies()
    {
        return array();
    }

    public function install()
    {

    }

    public function uninstall()
    {

    }

} 
