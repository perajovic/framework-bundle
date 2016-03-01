<?php

namespace SupportYard\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class InputPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('support_yard_framework.interceptor.manager')) {
            return;
        }

        $interceptors = [];

        $definition = $container->getDefinition(
            'support_yard_framework.interceptor.manager'
        );
        $services = $container->findTaggedServiceIds('support_yard_framework.input');

        foreach ($services as $inputId => $tags) {
            foreach ($tags as $attributes) {
                $metadata = $this->createServiceMetadata($attributes['alias']);

                if ($container->hasDefinition($metadata['interceptorId'])) {
                    continue;
                }

                $metadata['inputId'] = $inputId;
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
            'interceptorId' => implode('.', $interceptorId).'_input',
            'alias' => $alias.'_input',
        ];
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $metadata
     */
    private function registerService(ContainerBuilder $container, array $metadata)
    {
        $class = 'SupportYard\\FrameworkBundle\\Interceptor\\InputInterceptor';
        $interceptorId = $metadata['interceptorId'];
        $alias = $metadata['alias'];
        $inputId = $metadata['inputId'];

        $definition = new Definition($class, [new Reference('validator'), new Reference($inputId)]);
        $definition
            ->setLazy(true)
            ->addTag('support_yard_framework.interceptor', ['alias' => $alias]);
        $container->setDefinition($interceptorId, $definition);
    }
}
