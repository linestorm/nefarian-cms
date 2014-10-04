<?php

namespace Nefarian\CmsBundle\Plugin;

use Nefarian\CmsBundle\Plugin\Exception\PluginNotFoundException;

class PluginManager
{
    /**
     * @var Plugin[]
     */
    protected $plugins;

    /**
     * Register a plugin with the manager
     *
     * @param Plugin $plugin
     */
    public function registerPlugin(Plugin $plugin)
    {
        $this->plugins[$plugin->getName()] = $plugin;
    }

    /**
     * @param string $name
     *
     * @throws PluginNotFoundException
     * @return Plugin
     */
    public function getPlugin($name)
    {
        if (!$this->hasPlugin($name)) {
            throw new PluginNotFoundException($name);
        }

        return $this->plugins[$name];
    }

    /**
     * Get a list of all plugins, keyed by plugin name
     *
     * @return Plugin[]
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Check a plugin exists by name
     *
     * @param $name
     * @return bool
     */
    public function hasPlugin($name)
    {
        return array_key_exists($name, $this->plugins);
    }

    public function enablePlugin($name)
    {
        if(!$this->hasPlugin($name))
        {
            throw new PluginNotFoundException($name);
        }

        $plugin = $this->plugins[$name];
        $this->installPlugin($plugin);
    }

    public function installPlugin(Plugin $plugin)
    {
        $plugin->install();


    }


} 