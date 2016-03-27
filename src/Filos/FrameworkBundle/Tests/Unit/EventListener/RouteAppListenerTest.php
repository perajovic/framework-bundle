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

namespace Filos\FrameworkBundle\Tests\Unit\EventListener;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Filos\FrameworkBundle\EventListener\RouteAppListener;
use Filos\FrameworkBundle\Test\EventListenerTestCase;

class RouteAppListenerTest extends EventListenerTestCase
{
    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $this->ensureIsNotMasterRequest();

        $this->listener->onKernelView($this->event);
    }

    /**
     * @test
     */
    public function listenerIsStoppedIfResultIsNotControllerResultInstance()
    {
        $this->ensureIsMasterRequest();
        $this->ensureControllerResult(['foo' => 'bar']);

        $this->listener->onKernelView($this->event);
    }

    /**
     * @test
     * @dataProvider provideAppAttributes
     */
    public function attributesForMerge($controllerResultApp, $attributesApp, $merged)
    {
        $result = new ControllerResult([], $controllerResultApp);

        $this->request->attributes->set('_app', $attributesApp);

        $this->ensureIsMasterRequest();
        $this->ensureControllerResult($result);
        $this->ensureRequest();

        $this->listener->onKernelView($this->event);

        $this->assertEquals($merged, $result->app->all());
    }

    public function provideAppAttributes()
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

    protected function setUp()
    {
        parent::setUp();

        $this->request = $this->createRequest();
        $this->event = $this->createGetResponseForControllerResultEvent();
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
}
