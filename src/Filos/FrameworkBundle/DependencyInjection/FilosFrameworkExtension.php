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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class FilosFrameworkExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        $processedConfig = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter(
            'filos_framework.default_url_catcher_route',
            $processedConfig['app']['default_url_catcher_route']
        );
        $container->setParameter('filos_framework.app', $processedConfig['app']);
        $container->setParameter(
            'filos_framework.truncate_tables_between_tests',
            $processedConfig['truncate_tables_between_tests']
        );

        $this->registerTruncatableTablesService($container);
    }

    private function registerTruncatableTablesService(ContainerBuilder $container)
    {
        if (!$container->hasParameter('kernel.environment')) {
            return;
        }

        if (false === $container->getParameter('filos_framework.truncate_tables_between_tests')
            || 'test' !== $container->getParameter('kernel.environment')
        ) {
            return;
        }

        $definition = new Definition('Filos\FrameworkBundle\EventListener\TruncatableTablesListener');
        $definition->addTag('doctrine.event_listener', ['event' => 'postPersist']);
        $container->setDefinition('filos_framework.listener.truncatable_tables', $definition);
    }
}
