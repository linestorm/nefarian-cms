<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Router;

/**
 * Class RoutingProvider
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Router
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface RoutingProviderInterface
{
    /**
     * Get the route
     *
     * @return string
     */
    public function getRoute();
} 
