<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class InputPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('filos_framework.interceptor.manager')) {
            return;
        }

        $interceptors = [];

        $definition = $container->getDefinition('filos_framework.interceptor.manager');
        $services = $container->findTaggedServiceIds('filos_framework.input');

        foreach ($services as $inputId => $tags) {
            foreach ($tags as $attributes) {
                $metadata = $this->createServiceMetadata($attributes['alias']);

                if ($container->hasDefinition($metadata['interceptor_id'])) {
                    continue;
                }

                $metadata['input_id'] = $inputId;
                $this->registerService($container, $metadata);
                $interceptors[$metadata['alias']] = new Reference($metadata['interceptor_id']);
            }
        }

        $definition->addMethodCall('setInterceptors', [$interceptors]);
    }

    private function createServiceMetadata(string $alias): array
    {
        $interceptorId = explode('.', $alias);
        array_splice($interceptorId, 1, 0, 'interceptor');

        return [
            'interceptor_id' => implode('.', $interceptorId).'_input',
            'alias' => $alias.'_input',
        ];
    }

    private function registerService(ContainerBuilder $container, array $metadata)
    {
        $class = 'Filos\FrameworkBundle\Interceptor\InputInterceptor';
        $interceptorId = $metadata['interceptor_id'];
        $alias = $metadata['alias'];
        $inputId = $metadata['input_id'];

        $definition = new Definition($class, [new Reference('validator'), new Reference($inputId)]);
        $definition->setLazy(true)->addTag('filos_framework.interceptor', ['alias' => $alias]);
        $container->setDefinition($interceptorId, $definition);
    }
}
