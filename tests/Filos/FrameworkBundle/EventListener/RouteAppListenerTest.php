<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Filos\FrameworkBundle\EventListener\RouteAppListener;
use Filos\FrameworkBundle\TestCase\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;

class RouteAppListenerTest extends TestCase
{
    /**
     * @var AppKernel
     */
    private $kernel;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var RouteAppListener
     */
    private $listener;

    /**
     * @var ControllerResult
     */
    private $controllerResult;

    public function setUp()
    {
        parent::setUp();

        $this->controllerResult = new ControllerResult();
        $this->kernel = new AppKernel('test', true);
        $this->request = Request::create('/_listener');
        $this->listener = new RouteAppListener([
            'page_title' => null,
            'page_template' => null,
            'action_callback' => null,
            'action_data' => [],
            'status_code' => 200,
        ]);
    }

    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $this->request->attributes->set('_app', ['foo' => 'bar']);
        $this->controllerResult->app = ['foo' => 'baz'];

        $event = $this->createGetResponseForControllerResultEvent(
            HttpKernelInterface::SUB_REQUEST,
            $this->controllerResult
        );

        $this->listener->onKernelView($event);

        $this->assertSame('bar', $this->request->get('_app')['foo']);
    }

    /**
     * @test
     */
    public function listenerIsStoppedIfResultIsNotControllerResultInstance()
    {
        $event = $this->createGetResponseForControllerResultEvent(
            HttpKernelInterface::MASTER_REQUEST,
            ['foo' => 'bar']
        );

        $this->listener->onKernelView($event);
    }

    /**
     * @test
     *
     * @dataProvider provideAppAttributes
     */
    public function attributesForMerge(array $controllerResultApp, array $attributesApp, array $merged)
    {
        $this->controllerResult->app->replace($controllerResultApp);
        $this->request->attributes->set('_app', $attributesApp);

        $event = $this->createGetResponseForControllerResultEvent(
            HttpKernelInterface::MASTER_REQUEST,
            $this->controllerResult
        );

        $this->listener->onKernelView($event);

        $this->assertEquals($merged, $this->controllerResult->app->all());
    }

    public function provideAppAttributes(): array
    {
        return [
            [
                [],
                [],
                [
                    'page_title' => null,
                    'page_template' => null,
                    'action_data' => [],
                    'action_callback' => null,
                    'status_code' => 200,
                ],
            ],
            [
                [],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'action_callback' => 'controller:action',
                    'action_data' => ['foo' => 'bar'],
                    'status_code' => 400,
                ],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'action_callback' => 'controller:action',
                    'action_data' => ['foo' => 'bar'],
                    'status_code' => 400,
                ],
            ],
            [
                [
                    'page_title' => 'Title 1',
                    'page_template' => 'template 1',
                    'action_callback' => 'controller_1:action_1',
                    'action_data' => ['foo' => 'bar 1', 'bar' => 'baz'],
                    'status_code' => 500,
                ],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'action_callback' => 'controller:action',
                    'action_data' => ['foo' => 'bar'],
                    'status_code' => 400,
                ],
                [
                    'page_title' => 'Title 1',
                    'page_template' => 'template 1',
                    'action_callback' => 'controller_1:action_1',
                    'action_data' => ['foo' => 'bar 1', 'bar' => 'baz'],
                    'status_code' => 500,
                ],
            ],
        ];
    }

    /**
     * @param int                    $requestType
     * @param ControllerResult|mixed $controllerResult
     */
    private function createGetResponseForControllerResultEvent(
        int $requestType,
        $controllerResult
    ): GetResponseForControllerResultEvent {
        return new GetResponseForControllerResultEvent(
            $this->kernel,
            $this->request,
            $requestType,
            $controllerResult
        );
    }
}
