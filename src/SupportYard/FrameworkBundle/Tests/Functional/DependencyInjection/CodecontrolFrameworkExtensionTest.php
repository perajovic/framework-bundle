<?php

namespace SupportYard\FrameworkBundle\Tests\Functional\DependencyInjection;

use SupportYard\FrameworkBundle\DependencyInjection\SupportYardFrameworkExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class CodecontrolFrameworkExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function appParameterIsSettled()
    {
        $appParam = ['foo' => 'bar'];

        $this->load();

        $this->assertContainerBuilderHasParameter(
            'supportyard_framework.app',
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
            'supportyard_framework.listener.truncatable_tables'
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
            'supportyard_framework.listener.truncatable_tables'
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
            'supportyard_framework.listener.truncatable_tables',
            'SupportYard\FrameworkBundle\EventListener\TruncatableTablesListener'
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'supportyard_framework.listener.truncatable_tables',
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
        return [new SupportYardFrameworkExtension()];
    }
}
