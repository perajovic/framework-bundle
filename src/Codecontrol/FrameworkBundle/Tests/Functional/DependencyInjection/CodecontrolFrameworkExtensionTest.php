<?php

namespace Codecontrol\FrameworkBundle\Tests\Functional\DependencyInjection;

use Codecontrol\FrameworkBundle\DependencyInjection\CodecontrolFrameworkExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\DependencyInjection\Definition;

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
            'codecontrol_framework.app',
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
            'codecontrol_framework.listener.truncatable_tables'
        );
    }

    /**
     * @test
     */
    public function truncatableTablesServiceIsNotRegisteredForNonTestKernelEnvironment()
    {
        $this->setParameter('kernel.environment', 'dev');
        $this->setDefinition('doctrine', new Definition('stdClass'));
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderNotHasService(
            'codecontrol_framework.listener.truncatable_tables'
        );
    }

    /**
     * @test
     */
    public function truncatableTablesServiceIsRegistered()
    {
        $this->setParameter('kernel.environment', 'test');
        $this->setDefinition('doctrine', new Definition('stdClass'));
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderHasService(
            'codecontrol_framework.listener.truncatable_tables',
            'Codecontrol\FrameworkBundle\EventListener\TruncatableTablesListener'
        );
        $this->assertContainerBuilderHasServiceDefinitionWithTag(
            'codecontrol_framework.listener.truncatable_tables',
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
        return [new CodecontrolFrameworkExtension()];
    }
}
