<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Filos\FrameworkBundle\Tests\DependencyInjection\Compiler;

use Filos\FrameworkBundle\DependencyInjection\Compiler\InputPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class InputPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function taggedInterceptorsAreResolved()
    {
        $collectingService = new Definition();
        $this->setDefinition('filos_framework.interceptor.manager', $collectingService);

        $collectedService1 = new Definition();
        $collectedService1->addTag('filos_framework.input', ['alias' => 'app_bundle.service_1']);
        $this->setDefinition('collected_service_1', $collectedService1);

        $collectedService2 = new Definition();
        $collectedService2->addTag('filos_framework.input', ['alias' => 'app_bundle.service_2']);
        $this->setDefinition('collected_service_2', $collectedService2);

        $collectedService3 = new Definition();
        $collectedService3->addTag('filos_framework.input', ['alias' => 'app_bundle.service_3']);
        $this->setDefinition('collected_service_3', $collectedService3);

        $interceptor3 = new Definition();
        $this->setDefinition('app_bundle.interceptor.service_3_input', $interceptor3);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'filos_framework.interceptor.manager',
            'setInterceptors',
            [[
                'app_bundle.service_1_input' => new Reference('app_bundle.interceptor.service_1_input'),
                'app_bundle.service_2_input' => new Reference('app_bundle.interceptor.service_2_input'),
            ]]
        );

        $this->assertContainerBuilderHasService('app_bundle.interceptor.service_3_input');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InputPass());
    }
}
