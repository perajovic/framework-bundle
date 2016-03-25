<?php

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
        $definition = $container->getDefinition(
            'filos_framework.interceptor.manager'
        );
        $services = $container->findTaggedServiceIds(
            'filos_framework.interceptor'
        );

        foreach ($services as $id => $tags) {
            foreach ($tags as $attributes) {
                $interceptors[$attributes['alias']] = new Reference($id);
            }
        }

        $definition->addMethodCall('setInterceptors', [$interceptors]);
    }
}
