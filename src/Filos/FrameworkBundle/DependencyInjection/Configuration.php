<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('filos_framework');

        $rootNode
            ->children()
                ->arrayNode('app')
                    ->info('Values which are merged into route defaults')
                    ->children()
                        ->booleanNode('no_cache')
                            ->info('Configure non caching headers for every response')
                            ->defaultValue(false)
                        ->end()
                        ->booleanNode('send_flatten')
                            ->info('Configure error payloads in error responses')
                            ->defaultValue(true)
                        ->end()
                        ->integerNode('status_code')
                            ->info('Configure default status code for every response')
                            ->defaultValue(200)
                        ->end()
                        ->scalarNode('page_title')
                            ->info('Configure default page title for every XHR response')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('action_callback')
                            ->info('Configure default Javascript RPC callback for every XHR response')
                            ->defaultValue(null)
                        ->end()
                        ->arrayNode('action_data')
                            ->info('Configure default Javascript RPC callback data for every XHR response')
                            ->prototype('variable')->end()
                        ->end()
                        ->arrayNode('interceptors')
                            ->info('Configure interceptors for every response')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('truncate_tables_between_tests')
                    ->info('Should tables be truncated between tests. This operation requires kernel environment test mode and doctrine service')
                    ->defaultValue(false)
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
