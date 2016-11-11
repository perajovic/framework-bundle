<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\DependencyInjection;

use Tests\Filos\FrameworkBundle\Fixture\AppKernel;
use Filos\FrameworkBundle\TestCase\FunctionalTestCase;

class ServiceInstancesTest extends FunctionalTestCase
{
    /**
     * @test
     * @dataProvider provideService
     */
    public function checkIfServicesIsInstantiable($class, $serviceId)
    {
        $this->assertInstanceOf($class, $this->getService($serviceId));
    }

    public function provideService(): array
    {
        return [
            ['Filos\FrameworkBundle\Controller\ExceptionController', 'filos_framework.controller.exception'],
            ['Filos\FrameworkBundle\EventListener\InterceptorListener', 'filos_framework.listener.interceptor'],
            ['Filos\FrameworkBundle\EventListener\RequestFormatListener', 'filos_framework.listener.request_format'],
            ['Filos\FrameworkBundle\EventListener\ResponseDecoratorListener', 'filos_framework.listener.response_decorator'],
            ['Filos\FrameworkBundle\EventListener\RouteAppListener', 'filos_framework.listener.route_app'],
            ['Filos\FrameworkBundle\EventListener\ViewRendererListener', 'filos_framework.listener.view_renderer'],
            ['Filos\FrameworkBundle\Interceptor\InterceptorManager', 'filos_framework.interceptor.manager'],
            ['Filos\FrameworkBundle\Utils\Escaper', 'filos_framework.utils.escaper'],
            ['Filos\FrameworkBundle\Utils\PasswordHelper', 'filos_framework.utils.password_helper'],
        ];
    }

    protected static function createKernel(array $options = []): AppKernel
    {
        return new AppKernel('test', true);
    }
}
