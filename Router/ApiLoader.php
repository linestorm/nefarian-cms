<?php

namespace Nefarian\CmsBundle\Router;

use Nefarian\CmsBundle\Plugin\Plugin;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Yaml\Parser;

class ApiLoader extends Loader
{
    /**
     * All resources
     *
     * @var array[]
     */
    private $resources = array();

    /**
     * Array of app plugin paths
     *
     * @var Plugin[]
     */
    private $plugins = array();

    /**
     * Add a resource to the stack
     *
     * @param string $resource
     * @param Plugin $plugin
     *
     * @internal param $name
     */
    public function addPluginResource(Plugin $plugin, $resource)
    {
        $this->resources[$plugin->getName()][] = $resource;
        $this->plugins[$plugin->getName()] = $plugin;
    }

    /**
     * Load all resources into the router
     *
     * @param mixed $resource
     * @param null  $type
     *
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();
        foreach($this->resources as $pluginName => $routeResources)
        {
            $pluginRoutes = new RouteCollection();
            foreach($routeResources as $routeResource)
            {
                $resourceRoutes = $this->import($routeResource, 'rest');
                $pluginRoutes->addCollection($resourceRoutes);
            }

            $pluginRoutes->addPrefix('/' . $pluginName);

            // prefix all the routes with the plugin base
            foreach($pluginRoutes->all() as $name => $route)
            {
                $routes->add('nefarian_api_' . $pluginName . '_' . $name, $route);
            }
        }

        $routes->addPrefix('/api');

        return $routes;
    }

    /**
     * @param mixed $resource
     * @param null  $type
     *
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return 'nefarian_api' === $type;
    }


}
