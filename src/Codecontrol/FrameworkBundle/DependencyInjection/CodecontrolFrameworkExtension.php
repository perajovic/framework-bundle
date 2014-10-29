<?php

namespace Codecontrol\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class CodecontrolFrameworkExtension extends Extension
{
    /**
     * {@inheritDoc}
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
            'codecontrol_framework.app',
            $processedConfig['app']
        );
        $container->setParameter(
            'codecontrol_framework.truncate_tables_between_tests',
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

        if (false === $container->getParameter('codecontrol_framework.truncate_tables_between_tests')
            || 'test' !== $container->getParameter('kernel.environment')
        ) {
            return;
        }

        $definition = new Definition(
            'Codecontrol\\FrameworkBundle\\EventListener\\TruncatableTablesListener'
        );
        $definition->addTag('doctrine.event_listener', ['event' => 'postPersist']);
        $container->setDefinition(
            'codecontrol_framework.listener.truncatable_tables',
            $definition
        );
    }
}
