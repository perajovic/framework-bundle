<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\EventListener\InterceptorListener;
use Filos\FrameworkBundle\Interceptor\InterceptorManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;
use Tests\Filos\FrameworkBundle\Fixture\FooInterceptor;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class InterceptorListenerTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var InterceptorManager
     */
    private $manager;

    /**
     * @var InterceptorListener
     */
    private $listener;

    /**
     * @var AppKernel
     */
    private $kernel;

    /**
     * @var FooInterceptor
     */
    private $interceptor;

    public function setUp()
    {
        parent::setUp();

        $this->kernel = new AppKernel('test', true);
        $this->request = Request::create('/_listener');
        $this->interceptor = new FooInterceptor();
        $this->manager = new InterceptorManager(['foo' => $this->interceptor]);
        $this->listener = new InterceptorListener($this->manager);
    }

    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $event = $this->createFilterControllerEvent(HttpKernelInterface::SUB_REQUEST);

        $this->listener->onKernelController($event);

        $this->assertFalse($this->interceptor->executed);
    }

    /**
     * @test
     */
    public function ifAppRouteParamDoesNotExistListenerExecutionIsStopped()
    {
        $event = $this->createFilterControllerEvent(HttpKernelInterface::MASTER_REQUEST);

        $this->listener->onKernelController($event);

        $this->assertFalse($this->interceptor->executed);
    }

    /**
     * @test
     */
    public function managerHandledRequest()
    {
        $event = $this->createFilterControllerEvent(HttpKernelInterface::MASTER_REQUEST);
        $this->request->attributes->set('_app', ['interceptors' => ['foo']]);

        $this->listener->onKernelController($event);

        $this->assertTrue($this->interceptor->executed);
    }

    /**
     * @param int $requestType
     *
     * @return FilterControllerEvent
     */
    private function createFilterControllerEvent(int $requestType): FilterControllerEvent
    {
        return new FilterControllerEvent(
            $this->kernel,
            function () {
            },
            $this->request,
            $requestType
        );
    }
}
