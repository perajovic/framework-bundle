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

use Filos\FrameworkBundle\EventListener\RequestFormatListener;
use Filos\FrameworkBundle\Test\EventListenerTestCase;

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
