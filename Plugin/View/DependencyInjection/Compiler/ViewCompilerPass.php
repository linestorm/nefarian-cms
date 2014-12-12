<?php

namespace Nefarian\CmsBundle\Plugin\View\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ViewCompilerPass
 *
 * @package Nefarian\CmsBundle\Plugin\View\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $viewServices = $container->findTaggedServiceIds('nefarian.view');
        $viewManager = $container->findDefinition('nefarian.plugin.view.view_manager');

        foreach($viewServices as $sid => $params)
        {
            $viewManager->addMethodCall('addView', array(new Reference($sid)));
        }
    }
} 
