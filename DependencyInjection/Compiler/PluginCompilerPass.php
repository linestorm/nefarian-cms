<?php

namespace Nefarian\CmsBundle\DependencyInjection\Compiler;

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
        $plugins = $container->getParameter('nefarian_cms.plugins');

        foreach($plugins as $pluginClass)
        {
            /** @var Plugin $plugin */
            $plugin = new $pluginClass();
            $plugin->boot();
            $path = $plugin->getPath();

            $yamlParser = new Parser();

            // load the module config
            $moduleYaml = $path . DIRECTORY_SEPARATOR . 'module.yml';
            if(file_exists($moduleYaml))
            {
                $moduleConfig = $yamlParser->parse(file_get_contents($moduleYaml));
            }

            // TODO: Load module routing

            // TODO: Load module menu

            // TODO: Load module entities

            // TODO: Load module services?
        }
    }

} 
