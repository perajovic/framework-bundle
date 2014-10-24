<?php

namespace Codecontrol\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class InterceptorPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('codecontrol_framework.interceptor.manager')) {
            return;
        }

        $interceptors = [];

        $managerDefinition = $container->getDefinition(
            'codecontrol_framework.interceptor.manager'
        );
        $services = $container->findTaggedServiceIds(
            'codecontrol_framework.interceptor'
        );

        foreach ($services as $id => $tags) {
            foreach ($tags as $attributes) {
                $interceptors[$attributes['alias']] = new Reference($id);
            }
        }

        $managerDefinition->addMethodCall('setInterceptors', [$interceptors]);
    }
}
