<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Filos\FrameworkBundle\EventListener\ViewRendererListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Templating\EngineInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;
use Tests\Filos\FrameworkBundle\Fixture\Engine;
use Filos\FrameworkBundle\TestCase\TestCase;

class ViewRendererListenerTest extends TestCase
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
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var ViewRendererListener
     */
    private $listener;

    public function setUp()
    {
        parent::setUp();

        $this->kernel = new AppKernel('test', true);
        $this->request = Request::create('/_listener_test');
        $this->templating = new Engine();
        $this->listener = new ViewRendererListener($this->templating);
    }

    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $event = $this->createGetResponseForControllerResultEvent(HttpKernelInterface::SUB_REQUEST, null);

        $this->listener->onKernelView($event);
    }

    /**
     * @test
     */
    public function listenerIsStoppedIfResultIsNotControllerResultInstance()
    {
        $event = $this->createGetResponseForControllerResultEvent(HttpKernelInterface::MASTER_REQUEST, ['foo' => 'bar']);

        $this->listener->onKernelView($event);
    }

    /**
     * @test
     */
    public function ifTemplateIsNotConfiguredEmptyResponseisSettled()
    {
        $view = ['foo_var' => 'bar'];

        $result = new ControllerResult($view);

        $event = $this->createGetResponseForControllerResultEvent(HttpKernelInterface::MASTER_REQUEST, $result);

        $this->listener->onKernelView($event);

        $this->assertEmpty($event->getResponse()->getContent());
    }

    /**
     * @test
     */
    public function templateIsRenderedWithContent()
    {
        $view = ['foo_var' => 'bar'];
        $template = 'view.html';

        $result = new ControllerResult($view, ['page_template' => $template]);

        $event = $this->createGetResponseForControllerResultEvent(HttpKernelInterface::MASTER_REQUEST, $result);

        $this->listener->onKernelView($event);

        $this->assertSame('view.html foo_var bar', $event->getResponse()->getContent());
    }

    /**
     * @param string                 $requestType
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
