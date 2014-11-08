<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Router\Provider;

use Nefarian\CmsBundle\Plugin\ContentManagement\Router\RoutingProviderInterface;
use Symfony\Component\Routing\Route;

/**
 * Class SlugRoutingProvider
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Router\Provider
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class SlugRoutingProvider implements RoutingProviderInterface
{
    /**
     * Get the route
     *
     * @return string
     */
    public function getRoute()
    {
        return new Route('');
    }
}
