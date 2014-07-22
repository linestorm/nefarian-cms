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


} 
