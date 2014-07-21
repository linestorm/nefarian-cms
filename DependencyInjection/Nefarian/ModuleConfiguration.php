<?php

namespace Nefarian\CmsBundle\DependencyInjection\Nefarian;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ModuleConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('module');

        $rootNode->isRequired()
            ->children()
                ->scalarNode('name')->isRequired()->end()
                ->scalarNode('category')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
} 
