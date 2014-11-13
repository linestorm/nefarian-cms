<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ConfigurationCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigurationCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $configManagerDefinition = $container->getDefinition('nefarian_core.config_manager');
        $configurationServices   = $container->findTaggedServiceIds('nefarian.configuration');

        $configs = array();

        foreach ($configurationServices as $sid => $params) {
            $configs[] = new Reference($sid);
        }

        $configManagerDefinition->addMethodCall('setBaseConfigurations', array(
            $configs,
        ));
    }
} 
