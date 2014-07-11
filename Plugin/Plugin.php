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
    private $path;

    /**
     * @var \ReflectionClass
     */
    private $metaClass;

    /**
     * Boot the plugin
     *
     * @return $this
     */
    public function boot()
    {
        $this->metaClass = new \ReflectionClass($this);
        $this->path = pathinfo($this->metaClass->getFileName(), PATHINFO_DIRNAME);

        return $this;
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


} 
