<?php

namespace Nefarian\CmsBundle\Router;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class PluginLoader extends Loader
{
    /**
     * All resources
     *
     * @var array[]
     */
    private $resources = array();

    /**
     * Add a resource to the stack
     *
     * @param $resource
     * @param $name
     */
    public function addResource($resource, $name)
    {
        $this->resources[$name][] = $resource;
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
                $resourceRoutes = $this->import($routeResource);
                $pluginRoutes->addCollection($resourceRoutes);
            }

            $pluginRoutes->addPrefix('/'.$pluginName);

            // prefix all the routes with the plugin base
            foreach($pluginRoutes->all() as $name => $route)
            {
                $routes->add('nefarian_plugin_'.$pluginName.'_'.$name, $route);
            }
        }

        $routes->addPrefix('/_cms/admin/plugins/');
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
        return 'nefarian_plugins' === $type;
    }


}
