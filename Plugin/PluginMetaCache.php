<?php

namespace Nefarian\CmsBundle\Plugin;

class PluginMetaCache
{
    /**
     * @var boolean
     */
    public $installed = false;

    /**
     * @var boolean
     */
    public $enabled;

    /**
     * @var string
     */
    public $pluginClass;

    /**
     * @var \ReflectionClass
     */
    public $pluginReflection;

    function __construct($pluginClass)
    {
        $this->pluginReflection = new \ReflectionClass($pluginClass);
    }

    function __sleep()
    {
        $this->pluginReflection = null;
    }

    function __wakeup()
    {
        $this->pluginReflection = new \ReflectionClass($this->pluginClass);
    }


} 