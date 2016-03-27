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

namespace Filos\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class InterceptorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('filos_framework.interceptor.manager')) {
            return;
        }

        $interceptors = [];
        $definition = $container->getDefinition('filos_framework.interceptor.manager');
        $services = $container->findTaggedServiceIds('filos_framework.interceptor');

        foreach ($services as $id => $tags) {
            foreach ($tags as $attributes) {
                $interceptors[$attributes['alias']] = new Reference($id);
            }
        }

        $definition->addMethodCall('setInterceptors', [$interceptors]);
    }
}
