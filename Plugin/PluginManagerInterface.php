<?php

namespace Nefarian\CmsBundle\Plugin;

interface PluginManagerInterface
{
    public function registerPlugin(Plugin $plugin);

    public function getPlugin($name);
} 