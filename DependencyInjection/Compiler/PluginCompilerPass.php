<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\Plugin\PluginCompiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Parser;

/**
 * Class PluginCompilerPass
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Compiler
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class PluginCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $plugins = $container->getParameter('nefarian_core.plugins');

        $pluginRouterDefinition = $container->getDefinition('nefarian_core.routing.plugin_loader');
        $menuManagerDefinition  = $container->getDefinition('nefarian_core.menu_manager');

        foreach($plugins as $pluginClass)
        {
            $plugin = new PluginCompiler($pluginClass);
            $plugin->compile();
            $path = $plugin->getPath();

            $yamlParser = new Parser();

            // configure the plugin service
            $pluginDefinitionId = 'nefarian.plugin.' . $plugin->getName();
            $pluginDefinition   = $container->register($pluginDefinitionId, $pluginClass);
            $pluginDefinition->addArgument($plugin->getName());
            $pluginReference = new Reference($pluginDefinitionId);

            // register the plugins with the router
            $routingResource = $plugin->getPath().'/routing.admin.yml';
            if(file_exists($routingResource))
            {
                $pluginRouterDefinition->addMethodCall('addPluginResource', array($pluginReference, $routingResource));
            }


            // Add the default plugin template path to the twig loader
            $loader         = $container->findDefinition('twig.loader');
            $templateFolder = $path . '/Resources/views';
            $templateNamespace = $this->toCamelCase($plugin->getName()) . 'Plugin';
            if(file_exists($templateFolder))
            {
                $loader->addMethodCall('addPath', array($templateFolder, $templateNamespace));
            }


            // TODO: Load module menu
            $menu = $plugin->getConfig('menu');
            foreach($menu as $item)
            {
                $menuManagerDefinition->addMethodCall('addLink', array(
                    $plugin->getName(),
                    $item['title'],
                    $item['route'],
                    $item['description'],
                ));
            }


            // TODO: Load module entities
            $modelPath = $path . DIRECTORY_SEPARATOR . '/Resources/model/doctrine';
            if(file_exists($modelPath))
            {
                $mappings = array(
                    $modelPath => $plugin->getNamespace() . '\Model',
                );
                $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('nefarian.entity_manager'), 'nefarian.backend_type_orm'));
            }


            // TODO: Load module services?
        }

    }


    /**
     * Convert a plugin name to camel case
     *
     * @param $name
     *
     * @return mixed
     */
    private function toCamelCase($name)
    {
        $name   = preg_replace('/[^a-zA-Z0-9]/', ' ', $name);
        $string = ucwords(strtolower($name));

        return str_replace(' ', '', $string);
    }


} 
