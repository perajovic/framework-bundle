<?php

namespace SupportYard\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SupportYardFrameworkExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');

        $processedConfig = $this->processConfiguration(
            new Configuration(),
            $configs
        );

        $container->setParameter(
            'supportyard_framework.app',
            $processedConfig['app']
        );
        $container->setParameter(
            'supportyard_framework.truncate_tables_between_tests',
            $processedConfig['truncate_tables_between_tests']
        );

        $this->registerTruncatableTablesService($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerTruncatableTablesService(ContainerBuilder $container)
    {
        if (!$container->hasParameter('kernel.environment')) {
            return;
        }

        if (false === $container->getParameter('supportyard_framework.truncate_tables_between_tests')
            || 'test' !== $container->getParameter('kernel.environment')
        ) {
            return;
        }

        $definition = new Definition(
            'SupportYard\\FrameworkBundle\\EventListener\\TruncatableTablesListener'
        );
        $definition->addTag('doctrine.event_listener', ['event' => 'postPersist']);
        $container->setDefinition(
            'supportyard_framework.listener.truncatable_tables',
            $definition
        );
    }
}
