<?php

namespace Nefarian\CmsBundle\DependencyInjection\Nefarian;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class FieldsConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('content_fields');

        $rootNode
            ->children()
                ->arrayNode('fields')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('class')->isRequired()->end()
                            ->scalarNode('handler')->isRequired()->end()
                             ->scalarNode('form')->isRequired()->end()
                            ->arrayNode('properties')
                                ->prototype('scalar')->end()
                        ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
} 
