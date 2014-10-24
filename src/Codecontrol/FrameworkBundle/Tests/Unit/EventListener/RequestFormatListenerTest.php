<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\EventListener;

use Codecontrol\FrameworkBundle\EventListener\RequestFormatListener;
use Codecontrol\FrameworkBundle\Test\EventListenerTestCase;

class RequestFormatListenerTest extends EventListenerTestCase
{
    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $this->ensureIsNotMasterRequest();

        $this->listener->onKernelRequest($this->event);
    }

    /**
     * @test
     */
    public function formatIsSettled()
    {
        $format = 'json';

        $this->request->headers->set('Accept', 'application/json');
        $this->request->setRequestFormat($format);

        $this->ensureIsMasterRequest();
        $this->ensureRequest();

        $this->listener->onKernelRequest($this->event);

        $this->assertSame($format, $this->request->getRequestFormat());
    }

    protected function setUp()
    {
        parent::setUp();

        $this->request = $this->createRequest();
        $this->event = $this->createGetResponseEvent();
        $this->listener = new RequestFormatListener();
    }
}
