<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Config;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class FieldBodyConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('field_body_config');

        $rootNode->isRequired()
          ->children()
            ->scalarNode('limit')->isRequired()->end()
            ->scalarNode('limit_required')->isRequired()->end()
          ->end()
        ;

        return $treeBuilder;
    }
}
