<?php

namespace SupportYard\FrameworkBundle\Tests\Functional\DependencyInjection\Compiler;

use SupportYard\FrameworkBundle\DependencyInjection\Compiler\AppRequestPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AppRequestPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function taggedInterceptorsAreResolved()
    {
        $collectingService = new Definition();
        $this->setDefinition(
            'supportyard_framework.interceptor.manager',
            $collectingService
        );

        $collectedService1 = new Definition();
        $collectedService1->addTag(
            'supportyard_framework.request',
            ['alias' => 'app_bundle.service_1']
        );
        $this->setDefinition('collected_service_1', $collectedService1);

        $collectedService2 = new Definition();
        $collectedService2->addTag(
            'supportyard_framework.request',
            ['alias' => 'app_bundle.service_2']
        );
        $this->setDefinition('collected_service_2', $collectedService2);

        $collectedService3 = new Definition();
        $collectedService3->addTag(
            'supportyard_framework.request',
            ['alias' => 'app_bundle.service_3']
        );
        $this->setDefinition('collected_service_3', $collectedService3);

        $interceptor3 = new Definition();
        $this->setDefinition(
            'app_bundle.interceptor.service_3_request',
            $interceptor3
        );

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'supportyard_framework.interceptor.manager',
            'setInterceptors',
            [[
                'app_bundle.service_1_request' => new Reference('app_bundle.interceptor.service_1_request'),
                'app_bundle.service_2_request' => new Reference('app_bundle.interceptor.service_2_request'),
            ]]
        );

        $this->assertContainerBuilderHasService(
            'app_bundle.interceptor.service_3_request'
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AppRequestPass());
    }
}
