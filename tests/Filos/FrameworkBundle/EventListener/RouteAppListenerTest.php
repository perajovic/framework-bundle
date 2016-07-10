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

namespace Tests\Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Filos\FrameworkBundle\EventListener\RouteAppListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

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
            'page_has_layout' => false,
            'page_has_menu' => false,
            'action_callback' => null,
            'action_data' => [],
            'response_status' => 200,
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
     *
     * @param array $controllerResultApp
     * @param array $attributesApp
     * @param array $merged
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

    /**
     * @return array
     */
    public function provideAppAttributes(): array
    {
        return [
            [
                [],
                [],
                [
                    'page_title' => null,
                    'page_template' => null,
                    'page_has_layout' => false,
                    'page_has_menu' => false,
                    'action_data' => [],
                    'action_callback' => null,
                    'response_status' => 200,
                ],
            ],
            [
                [],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'action_callback' => 'controller:action',
                    'action_data' => ['foo' => 'bar'],
                    'response_status' => 400,
                ],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'action_callback' => 'controller:action',
                    'action_data' => ['foo' => 'bar'],
                    'response_status' => 400,
                ],
            ],
            [
                [
                    'page_title' => 'Title 1',
                    'page_template' => 'template 1',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'action_callback' => 'controller_1:action_1',
                    'action_data' => ['foo' => 'bar 1', 'bar' => 'baz'],
                    'response_status' => 500,
                ],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'page_has_layout' => false,
                    'page_has_menu' => false,
                    'action_callback' => 'controller:action',
                    'action_data' => ['foo' => 'bar'],
                    'response_status' => 400,
                ],
                [
                    'page_title' => 'Title 1',
                    'page_template' => 'template 1',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'action_callback' => 'controller_1:action_1',
                    'action_data' => ['foo' => 'bar 1', 'bar' => 'baz'],
                    'response_status' => 500,
                ],
            ],
        ];
    }

    /**
     * @param int                    $requestType
     * @param ControllerResult|mixed $controllerResult
     *
     * @return GetResponseForControllerResultEvent
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
