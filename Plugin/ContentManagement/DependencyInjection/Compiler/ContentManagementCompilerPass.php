<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ContentManagementCompilerPass
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentManagementCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $pathProcessorManager = $container->findDefinition('nefarian.plugins.content_management.node_route_manager');
        $pathProcessors = $container->findTaggedServiceIds('nefarian.node.path_processor');

        foreach($pathProcessors as $sid => $args){
            $pathProcessorManager->addMethodCall('addPathProcessor', array(new Reference($sid)));
        }
    }

} 
