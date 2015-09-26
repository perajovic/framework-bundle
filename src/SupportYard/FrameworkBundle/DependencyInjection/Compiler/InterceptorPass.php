<?php

namespace SupportYard\FrameworkBundle\DependencyInjection\Compiler;

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
        if (!$container->hasDefinition('supportyard_framework.interceptor.manager')) {
            return;
        }

        $interceptors = [];
        $definition = $container->getDefinition(
            'supportyard_framework.interceptor.manager'
        );
        $services = $container->findTaggedServiceIds(
            'supportyard_framework.interceptor'
        );

        foreach ($services as $id => $tags) {
            foreach ($tags as $attributes) {
                $interceptors[$attributes['alias']] = new Reference($id);
            }
        }

        $definition->addMethodCall('setInterceptors', [$interceptors]);
    }
}
