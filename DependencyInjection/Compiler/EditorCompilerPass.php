<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class EditorCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class EditorCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $editorManagerDefinition = $container->findDefinition('nefarian_core.editor_manager');
        $editorServices = $container->findTaggedServiceIds('nefarian.editor');

        foreach($editorServices as $editorServiceId=>$props)
        {
            $editorDefinition = $container->getDefinition($editorServiceId);
            $editorManagerDefinition->addMethodCall('addEditor', array($editorDefinition));
        }

    }


} 
