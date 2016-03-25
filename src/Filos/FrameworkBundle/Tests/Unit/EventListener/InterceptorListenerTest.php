<?php

namespace Filos\FrameworkBundle\Tests\Unit\EventListener;

use Filos\FrameworkBundle\EventListener\InterceptorListener;
use Filos\FrameworkBundle\Test\EventListenerTestCase;

class InterceptorListenerTest extends EventListenerTestCase
{
    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $this->ensureIsNotMasterRequest();

        $this->listener->onKernelController($this->event);
    }

    /**
     * @test
     */
    public function ifAppRouteParamDoesNotExistListenerExecutionIsStopped()
    {
        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureManagerIsNotExecuted();

        $this->listener->onKernelController($this->event);
    }

    /**
     * @test
     */
    public function managerHandledRequest()
    {
        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->request->attributes->set('_app', ['interceptors' => ['foo']]);
        $this->ensureManagerIsExecuted();

        $this->listener->onKernelController($this->event);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->request = $this->createRequest();
        $this->event = $this->createFilterControllerEvent();
        $this->manager = $this->createInterceptorManager();
        $this->listener = new InterceptorListener($this->manager);
    }

    private function ensureManagerIsNotExecuted()
    {
        $this
            ->manager
            ->expects($this->never())
            ->method('handle');
    }

    private function ensureManagerIsExecuted()
    {
        $this
            ->manager
            ->expects($this->once())
            ->method('handle')
            ->with($this->request);
    }

    private function createInterceptorManager()
    {
        return $this->createMockFor(
            'Filos\FrameworkBundle\Interceptor\InterceptorManager'
        );
    }
}
