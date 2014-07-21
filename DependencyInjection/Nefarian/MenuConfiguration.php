<?php

namespace Nefarian\CmsBundle\DependencyInjection\Nefarian;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class MenuConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('menu');

        $rootNode
            ->prototype('array')
                ->children()
                    ->scalarNode('title')->isRequired()->end()
                    ->scalarNode('route')->isRequired()->end()
                    ->scalarNode('parent')->end()
                    ->scalarNode('description')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
} 
