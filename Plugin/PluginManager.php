<?php

namespace Nefarian\CmsBundle\Plugin;

use Doctrine\Common\Cache\Cache;
use Nefarian\CmsBundle\Cache\CacheManager;
use Nefarian\CmsBundle\Plugin\Exception\PluginNotFoundException;

class PluginManager
{
    /**
     * @var Plugin[]
     */
    protected $plugins;

    /**
     * @var Cache
     */
    protected $pluginCache;

    /**
     * @var PluginMetaCache[]
     */
    protected $pluginMeta = array();

    function __construct(CacheManager $cacheManager)
    {
        $this->pluginCache = $cacheManager->get('core.plugins');
    }

    /**
     * Register a plugin with the manager
     *
     * @param Plugin $plugin
     */
    public function registerPlugin(Plugin $plugin)
    {
        $cachedMeta = $this->pluginCache->fetch($plugin->getName());
        if (!$cachedMeta instanceof PluginMetaCache) {
            $cachedMeta = new PluginMetaCache($plugin->getName());
            $this->pluginCache->save($plugin->getName(), $cachedMeta);
        }
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
     * Check a plugin exists by name
     *
     * @param $name
     * @return bool
     */
    public function hasPlugin($name)
    {
        return array_key_exists($name, $this->plugins);
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

    public function enablePlugin(Plugin $plugin)
    {
        $name = $plugin->getName();
        $this->installPlugin($plugin);

        $this->pluginMeta[$name]->enabled = true;
        $this->pluginCache->save($name, $this->pluginCache[$name]);
    }

    public function disablePlugin(Plugin $plugin)
    {
        $name = $plugin->getName();
        $this->uninstallPlugin($plugin);

        $this->pluginMeta[$name]->enabled = false;
        $this->pluginCache->save($name, $this->pluginCache[$name]);
    }

    public function installPlugin(Plugin $plugin)
    {
        $name = $plugin->getName();
        $plugin->install();

        $this->pluginMeta[$name]->installed = true;
        $this->pluginCache->save($name, $this->pluginCache[$name]);
    }

    public function uninstallPlugin(Plugin $plugin)
    {
        $name = $plugin->getName();
        $plugin->uninstall();

        $this->pluginMeta[$name]->installed = false;
        $this->pluginCache->save($name, $this->pluginCache[$name]);
    }

} 