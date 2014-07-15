<?php

namespace Nefarian\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nefarian_cms');

        $rootNode->isRequired();
        $this->addPluginSection($rootNode);
        $this->addThemeSection($rootNode);

        return $treeBuilder;
    }

    private function addPluginSection(NodeDefinition $rootNode)
    {
        $rootNode->children()
            ->arrayNode('plugins')->isRequired()
                ->prototype('scalar')
                ->end()
            ->end()
        ->end();
    }

    private function addThemeSection(NodeDefinition $rootNode)
    {
        $rootNode->children()
            ->arrayNode('themes')->isRequired()
                ->prototype('scalar')
                ->end()
            ->end()
        ->end();
    }

}
