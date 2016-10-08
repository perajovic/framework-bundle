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

namespace Tests\Filos\FrameworkBundle\Interceptor;

use Filos\FrameworkBundle\Interceptor\InterceptorManager;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class InterceptorManagerTest extends TestCase
{
    /**
     * @var InterceptorManager
     */
    private $manager;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $interceptor;

    protected function setUp()
    {
        parent::setUp();

        $this->interceptor = $this->createInterceptor();
        $this->request = Request::create('/_interceptor_test');
        $this->manager = new InterceptorManager([]);
    }

    /**
     * @test
     */
    public function interceptorsForRouteAreNotConfigured()
    {
        $this->manager->handle($this->request);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Interceptor "foo_interceptor" for route "foo_route" not found.
     */
    public function ifInterceptorIsNotAddedToManagerExceptionIsThrown()
    {
        $attributes = [
            '_app' => ['interceptors' => ['foo_interceptor']],
            '_route' => 'foo_route',
        ];

        $this->request->attributes->replace($attributes);

        $this->manager->handle($this->request);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     * @expectedExceptionMessage 404 test status
     */
    public function interceptorThrowsException()
    {
        $fooInterceptor = $this->createInterceptor();
        $barInterceptor = $this->createInterceptor();
        $manager = new InterceptorManager([
            'foo_interceptor' => $fooInterceptor,
            'bar_interceptor' => $barInterceptor,
        ]);
        $attributes = ['_app' => [
            'interceptors' => ['foo_interceptor', 'bar_interceptor'],
        ]];

        $this->request->attributes->replace($attributes);
        $this->ensureInterceptorIsApplied($fooInterceptor);
        $this->ensureInterceptorThrowsException($barInterceptor);

        $manager->handle($this->request);
    }

    /**
     * @test
     */
    public function requestIsHandled()
    {
        $attributes = ['_app' => ['interceptors' => ['foo_interceptor']]];
        $manager = new InterceptorManager(['foo_interceptor' => $this->interceptor]);

        $this->request->attributes->replace($attributes);
        $this->ensureInterceptorIsApplied($this->interceptor);

        $manager->handle($this->request);
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $interceptor
     */
    private function ensureInterceptorThrowsException(PHPUnit_Framework_MockObject_MockObject $interceptor)
    {
        $interceptor
            ->expects($this->once())
            ->method('apply')
            ->with($this->request)
            ->will($this->throwException(new HttpException(404, '404 test status')));
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $interceptor
     */
    private function ensureInterceptorIsApplied(PHPUnit_Framework_MockObject_MockObject $interceptor)
    {
        $interceptor
            ->expects($this->once())
            ->method('apply')
            ->with($this->request);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createInterceptor(): PHPUnit_Framework_MockObject_MockObject
    {
        return $this->createMockFor('Filos\FrameworkBundle\Interceptor\InterceptorInterface');
    }
}
