<?php

namespace Nefarian\CmsBundle\Plugin\File\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FileCompilerPass
 *
 * @package Nefarian\CmsBundle\Plugin\File\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileCompilerPass implements CompilerPassInterface
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
        $taggedFileProviders = $container->findTaggedServiceIds('nefarian.file.provider');
        $fileManager = $container->findDefinition('nefarian.plugin.file.manager');
        $fileManager->addMethodCall('setDefaultProvider', array('local_storeage'));

        foreach($taggedFileProviders as $sid => $params){
            $fileManager->addMethodCall('addFileProvider', array(new Reference($sid)));
            if(isset($params[0]['default']) && $params[0]['default'] == true){
            }
        }
    }

} 
