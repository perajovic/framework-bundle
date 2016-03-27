<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Filos\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('filos_framework');

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
