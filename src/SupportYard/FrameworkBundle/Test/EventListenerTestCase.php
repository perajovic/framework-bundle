<?php

namespace SupportYard\FrameworkBundle\Test;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class EventListenerTestCase extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->translator = $this->createTranslator();
    }

    protected function ensureIsNotMasterRequest()
    {
        $this->ensureMasterRequest(false);
    }

    protected function ensureIsMasterRequest()
    {
        $this->ensureMasterRequest(true);
    }

    protected function ensureTranslatorMessage($message)
    {
        $this
            ->translator
            ->expects($this->atLeastOnce())
            ->method('trans')
            ->with($message)
            ->will($this->returnValue($message));
    }

    protected function ensureRequest()
    {
        $this
            ->event
            ->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($this->request));
    }

    protected function ensureResponse()
    {
        $this
            ->event
            ->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($this->response));
    }

    protected function ensureControllerResult($controllerResult)
    {
        $this
            ->event
            ->expects($this->once())
            ->method('getControllerResult')
            ->will($this->returnValue($controllerResult));
    }

    protected function createRequest()
    {
        return Request::create('/_listener_test');
    }

    protected function createResponse()
    {
        return new Response();
    }

    protected function createGetResponseForControllerResultEvent()
    {
        return $this->createMockFor(
            'Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent'
        );
    }

    protected function createGetResponseEvent()
    {
        return $this->createMockFor(
            'Symfony\Component\HttpKernel\Event\GetResponseEvent'
        );
    }

    protected function createFilterResponseEvent()
    {
        return $this->createMockFor(
            'Symfony\Component\HttpKernel\Event\FilterResponseEvent'
        );
    }

    protected function createGetResponseForExceptionEvent()
    {
        return $this->createMockFor(
            'Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent'
        );
    }

    protected function createPostResponseEvent()
    {
        return $this->createMockFor(
            'Symfony\Component\HttpKernel\Event\PostResponseEvent'
        );
    }

    protected function createFilterControllerEvent()
    {
        return $this->createMockFor(
            'Symfony\Component\HttpKernel\Event\FilterControllerEvent'
        );
    }

    protected function createTranslator()
    {
        return $this->createMockFor(
            'Symfony\Component\Translation\TranslatorInterface'
        );
    }

    private function ensureMasterRequest($isMaster)
    {
        $this
            ->event
            ->expects($this->once())
            ->method('isMasterRequest')
            ->will($this->returnValue($isMaster));
    }
}
