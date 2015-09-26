<?php

namespace SupportYard\FrameworkBundle\Tests\Functional\DependencyInjection;

use SupportYard\FrameworkBundle\DependencyInjection\SupportYardFrameworkExtension;
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
            'support_yard_framework.app',
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
            'support_yard_framework.listener.truncatable_tables'
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
            'support_yard_framework.listener.truncatable_tables'
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
            'support_yard_framework.listener.truncatable_tables',
            'SupportYard\FrameworkBundle\EventListener\TruncatableTablesListener'
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'support_yard_framework.listener.truncatable_tables',
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
