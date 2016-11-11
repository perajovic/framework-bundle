<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\DependencyInjection\Compiler;

use Filos\FrameworkBundle\DependencyInjection\Compiler\InterceptorPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class InterceptorPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function taggedInterceptorsAreResolved()
    {
        $collectingService = new Definition();
        $this->setDefinition('filos_framework.interceptor.manager', $collectingService);

        $collectedService1 = new Definition();
        $collectedService1->addTag('filos_framework.interceptor', ['alias' => 'interceptor_1']);
        $this->setDefinition('collected_service_1', $collectedService1);

        $collectedService2 = new Definition();
        $collectedService2->addTag('filos_framework.interceptor', ['alias' => 'interceptor_2']);
        $this->setDefinition('collected_service_2', $collectedService2);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'filos_framework.interceptor.manager',
            'setInterceptors',
            [[
                'interceptor_1' => new Reference('collected_service_1'),
                'interceptor_2' => new Reference('collected_service_2'),
            ]]
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InterceptorPass());
    }
}
