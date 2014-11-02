<?php

namespace Nefarian\CmsBundle\DependencyInjection\Nefarian;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class FieldsConfiguration
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Nefarian
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
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
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('class')->isRequired()->end()
                    ->scalarNode('form')->isRequired()->end()
                    ->arrayNode('assets')
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('properties')
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('configs')
                      ->prototype('array')
                        ->children()
                          ->arrayNode('fields')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('label')->defaultValue(null)->end()
                                ->scalarNode('default')->defaultValue(null)->end()
                                ->scalarNode('type')->defaultValue('text')->end()
                                ->variableNode('options')->defaultValue(array())->end()
                            ->end()
                        ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
} 
