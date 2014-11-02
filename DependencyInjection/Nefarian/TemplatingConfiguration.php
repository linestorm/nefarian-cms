<?php

namespace Nefarian\CmsBundle\DependencyInjection\Nefarian;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class TemplatingConfiguration
 *
 * @package Nefarian\CmsBundle\DependencyInjection\Nefarian
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TemplatingConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('templating');

        $rootNode
            ->children()
            ->arrayNode('forms')
                ->prototype('scalar')->end()
            ->end()
        ;

        return $treeBuilder;
    }
} 
