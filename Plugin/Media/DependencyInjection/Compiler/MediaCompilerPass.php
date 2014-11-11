<?php

namespace Nefarian\CmsBundle\Plugin\Media\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MediaCompilerPass
 *
 * @package Nefarian\CmsBundle\Plugin\Media\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class MediaCompilerPass implements CompilerPassInterface
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
        $taggedMediaProviders = $container->findTaggedServiceIds('nefarian.media.provider');
        $mediaManager = $container->findDefinition('nefarian.plugin.media.manager');
        $mediaManager->addMethodCall('setDefaultProvider', array('local_storeage'));

        foreach($taggedMediaProviders as $sid => $params){
            $mediaManager->addMethodCall('addMediaProvider', array(new Reference($sid)));
            if(isset($params[0]['default']) && $params[0]['default'] == true){
            }
        }
    }

} 
