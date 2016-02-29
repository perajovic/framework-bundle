<?php

namespace SupportYard\FrameworkBundle\Tests\Functional\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use SupportYard\FrameworkBundle\DependencyInjection\Compiler\InputPass;
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
        $this->setDefinition(
            'support_yard_framework.interceptor.manager',
            $collectingService
        );

        $collectedService1 = new Definition();
        $collectedService1->addTag(
            'support_yard_framework.input',
            ['alias' => 'app_bundle.service_1']
        );
        $this->setDefinition('collected_service_1', $collectedService1);

        $collectedService2 = new Definition();
        $collectedService2->addTag(
            'support_yard_framework.input',
            ['alias' => 'app_bundle.service_2']
        );
        $this->setDefinition('collected_service_2', $collectedService2);

        $collectedService3 = new Definition();
        $collectedService3->addTag(
            'support_yard_framework.input',
            ['alias' => 'app_bundle.service_3']
        );
        $this->setDefinition('collected_service_3', $collectedService3);

        $interceptor3 = new Definition();
        $this->setDefinition(
            'app_bundle.interceptor.service_3_input',
            $interceptor3
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'support_yard_framework.interceptor.manager',
            'setInterceptors',
            [[
                'app_bundle.service_1_input' => new Reference('app_bundle.interceptor.service_1_input'),
                'app_bundle.service_2_input' => new Reference('app_bundle.interceptor.service_2_input'),
            ]]
        );

        $this->assertContainerBuilderHasService(
            'app_bundle.interceptor.service_3_input'
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InputPass());
    }
}
