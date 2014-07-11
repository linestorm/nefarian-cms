<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

use Nefarian\CmsBundle\DependencyInjection\Compiler\Exception\PluginConfigNotFound;
use Nefarian\CmsBundle\Plugin\Plugin;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
            /** @var Plugin $plugin */
            $plugin = new $pluginClass();
            $plugin->boot();
            $path = $plugin->getPath();

            $yamlParser = new Parser();

            // load the module config
            $moduleYaml = $path . DIRECTORY_SEPARATOR . 'module.yml';
            if(!file_exists($moduleYaml))
            {
                throw new PluginConfigNotFound($moduleYaml);
            }

            $moduleConfig = $yamlParser->parse(file_get_contents($moduleYaml));

            // TODO: Load module routing
            $routingYaml = $path . DIRECTORY_SEPARATOR . 'routing.admin.yml';
            if(file_exists($routingYaml))
            {
                $pluginRouterDefinition->addMethodCall('addResource', array($routingYaml, $moduleConfig['name']));
            }

            // TODO: Load module menu
            $menuYaml = $path . DIRECTORY_SEPARATOR . 'menu.yml';
            if(file_exists($menuYaml))
            {
                $menuConfig = $yamlParser->parse(file_get_contents($menuYaml));

                foreach($menuConfig as $link)
                {
                    $menuManagerDefinition->addMethodCall('addLink', array(
                        $moduleConfig['name'],
                        $link['title'],
                        $link['route'],
                        $link['description'],
                    ));
                }
            }

            // TODO: Load module entities
            $modelPath = $path . DIRECTORY_SEPARATOR . '/Resources/model/doctrine';
            if(file_exists($modelPath))
            {
                $mappings = array(
                    $modelPath => $plugin->getNamespace() . '\Model',
                );
                $container->addCompilerPass(DoctrineOrmCompilerPass::getMappingsPass($mappings));
            }

            // TODO: Load module services?
        }

    }

} 
