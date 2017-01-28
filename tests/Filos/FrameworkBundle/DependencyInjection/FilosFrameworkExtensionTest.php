<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\DependencyInjection;

use Filos\FrameworkBundle\DependencyInjection\FilosFrameworkExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class FilosFrameworkExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function truncatableTablesServiceIsNotRegisteredWhenKernelEnvironmentDoesNotExist()
    {
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderNotHasService('filos_framework.listener.truncatable_tables');
    }

    /**
     * @test
     */
    public function truncatableTablesServiceIsNotRegisteredForNonTestKernelEnvironment()
    {
        $this->setParameter('kernel.environment', 'dev');
        $this->load(['truncate_tables_between_tests' => true]);

        $this->assertContainerBuilderNotHasService('filos_framework.listener.truncatable_tables');
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

    /**
     * @test
     */
    public function defaultUrlCatcherRouteParameterIsSettled()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('filos_framework.default_url_catcher_route', '');
    }

    protected function getMinimalConfiguration(): array
    {
        return ['app' => []];
    }

    protected function getContainerExtensions(): array
    {
        return [new FilosFrameworkExtension()];
    }
}
