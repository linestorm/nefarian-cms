<?php

namespace Nefarian\CmsBundle\Plugin;

/**
 * Class Plugin
 *
 * @package Nefarian\CmsBundle\Plugin
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Plugin
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
     * @param string $name
     */
    function __construct($name)
    {
        $this->name = $name;

        $this->meta = new \ReflectionClass($this);
        $this->path = pathinfo($this->meta->getFileName(), PATHINFO_DIRNAME);
        $this->namespace = $this->meta->getNamespaceName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
