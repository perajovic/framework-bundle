<?php

namespace Filos\FrameworkBundle\Tests\Unit\EventListener;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Filos\FrameworkBundle\EventListener\ViewRendererListener;
use Filos\FrameworkBundle\Test\EventListenerTestCase;

class ViewRendererListenerTest extends EventListenerTestCase
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
     */
    public function templateIsRendered()
    {
        $view = ['foo' => 'bar'];
        $template = 'foo.html';

        $result = new ControllerResult($view, ['page_template' => $template]);

        $this->ensureIsMasterRequest();
        $this->ensureControllerResult($result);
        $this->ensureTemplateIsRendered($view, $template);

        $this->listener->onKernelView($this->event);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->request = $this->createRequest();
        $this->templating = $this->createTemplating();
        $this->event = $this->createGetResponseForControllerResultEvent();
        $this->listener = new ViewRendererListener($this->templating);
    }

    private function ensureTemplateIsRendered($view, $template)
    {
        $this
            ->templating
            ->expects($this->once())
            ->method('render')
            ->with($template, $view)
            ->will($this->returnValue('template rendered'));
    }

    private function createTemplating()
    {
        return $this->createMockFor('Symfony\Component\Templating\EngineInterface');
    }
}
