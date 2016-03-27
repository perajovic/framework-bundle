<?php

namespace Filos\FrameworkBundle\Tests\Functional\DependencyInjection;

use Filos\FrameworkBundle\DependencyInjection\FilosFrameworkExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class SupportYardFrameworkExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function appParameterIsSettled()
    {
        $appParam = ['foo' => 'bar'];

        $this->load();

        $this->assertContainerBuilderHasParameter(
            'filos_framework.app',
            $appParam
        );
    }

    /**
     * @test
     */
    public function truncatableTablesServiceIsNotRegisteredWhenKernelEnvironmentDoesNotExist()
    {
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderNotHasService(
            'filos_framework.listener.truncatable_tables'
        );
    }

    /**
     * @test
     */
    public function truncatableTablesServiceIsNotRegisteredForNonTestKernelEnvironment()
    {
        $this->setParameter('kernel.environment', 'dev');
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderNotHasService(
            'filos_framework.listener.truncatable_tables'
        );
    }

    /**
     * @test
     */
    public function truncatableTablesServiceIsRegistered()
    {
        $this->setParameter('kernel.environment', 'test');
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderHasService(
            'filos_framework.listener.truncatable_tables',
            'Filos\FrameworkBundle\EventListener\TruncatableTablesListener'
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'filos_framework.listener.truncatable_tables',
            'doctrine.event_listener',
            ['event' => 'postPersist']
        );
    }

    protected function getMinimalConfiguration()
    {
        return ['app' => ['foo' => 'bar']];
    }

    protected function getContainerExtensions()
    {
        return [new FilosFrameworkExtension()];
    }
}
