<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\EventListener;

use Codecontrol\FrameworkBundle\Controller\ControllerResult;
use Codecontrol\FrameworkBundle\EventListener\RouteAppListener;
use Codecontrol\FrameworkBundle\Test\EventListenerTestCase;

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
                    'page_data' => [],
                    'page_callback' => null,
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
                    'page_callback' => 'controller:action',
                    'page_data' => ['foo' => 'bar'],
                    'response_status' => 400,
                ],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'page_callback' => 'controller:action',
                    'page_data' => ['foo' => 'bar'],
                    'response_status' => 400,
                ],
            ],
            [
                [
                    'page_title' => 'Title 1',
                    'page_template' => 'template 1',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'page_callback' => 'controller_1:action_1',
                    'page_data' => ['foo' => 'bar 1', 'bar' => 'baz'],
                    'response_status' => 500,
                ],
                [
                    'page_title' => 'Title',
                    'page_template' => 'template',
                    'page_has_layout' => false,
                    'page_has_menu' => false,
                    'page_callback' => 'controller:action',
                    'page_data' => ['foo' => 'bar'],
                    'response_status' => 400,
                ],
                [
                    'page_title' => 'Title 1',
                    'page_template' => 'template 1',
                    'page_has_layout' => true,
                    'page_has_menu' => true,
                    'page_callback' => 'controller_1:action_1',
                    'page_data' => ['foo' => 'bar 1', 'bar' => 'baz'],
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
            'page_callback' => null,
            'page_data' => [],
            'response_status' => 200,
        ]);
    }
}
