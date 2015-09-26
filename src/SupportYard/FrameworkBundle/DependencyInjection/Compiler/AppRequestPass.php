<?php

namespace SupportYard\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AppRequestPass implements CompilerPassInterface
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
        $services = $container->findTaggedServiceIds('supportyard_framework.request');

        foreach ($services as $appRequestId => $tags) {
            foreach ($tags as $attributes) {
                $metadata = $this->createServiceMetadata($attributes['alias']);

                if ($container->hasDefinition($metadata['interceptorId'])) {
                    continue;
                }

                $metadata['appRequestId'] = $appRequestId;
                $this->registerService($container, $metadata);
                $interceptors[$metadata['alias']] = new Reference(
                    $metadata['interceptorId']
                );
            }
        }

        $definition->addMethodCall('setInterceptors', [$interceptors]);
    }

    /**
     * @param string $alias
     *
     * @return array
     */
    private function createServiceMetadata($alias)
    {
        $interceptorId = explode('.', $alias);
        array_splice($interceptorId, 1, 0, 'interceptor');

        return [
            'interceptorId' => implode('.', $interceptorId).'_request',
            'alias' => $alias.'_request',
        ];
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $metadata
     */
    private function registerService(ContainerBuilder $container, array $metadata)
    {
        $class = 'SupportYard\\FrameworkBundle\\Interceptor\\AppRequestInterceptor';
        $interceptorId = $metadata['interceptorId'];
        $alias = $metadata['alias'];
        $appRequestId = $metadata['appRequestId'];

        $definition = new Definition($class, [new Reference($appRequestId)]);
        $definition
            ->setLazy(true)
            ->addTag('supportyard_framework.interceptor', ['alias' => $alias]);
        $container->setDefinition($interceptorId, $definition);
    }
}
