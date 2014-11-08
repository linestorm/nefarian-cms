<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Router;

use Symfony\Cmf\Component\Routing\ChainRouterInterface;

/**
 * Class NodeRouterManager
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Router
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeRouterManager
{
    /**
     * @var ChainRouterInterface
     */
    protected $router;

    function __construct(ChainRouterInterface $router)
    {
        $this->router = $router;

        var_dump($this->router);
        die;
    }


} 
