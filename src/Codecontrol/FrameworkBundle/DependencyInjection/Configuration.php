<?php

namespace Codecontrol\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('codecontrol_framework');

        $rootNode
            ->children()
                ->arrayNode('app')
                    ->info('Values which are merged into route defaults.')
                    ->isRequired()
                    ->prototype('variable')->end()
                ->end()
                ->booleanNode('truncate_tables_between_tests')
                    ->defaultValue(false)
                    ->info('Should tables be truncated between tests. This operation requires kernel environment test mode and doctrine service')
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
