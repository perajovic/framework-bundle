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

use Filos\FrameworkBundle\EventListener\RequestFormatListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class RequestFormatListenerTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var RequestFormatListener
     */
    private $listener;

    /**
     * @var AppKernel
     */
    private $kernel;

    public function setUp()
    {
        parent::setUp();

        $this->kernel = new AppKernel('test', true);
        $this->request = Request::create('/_listener');
        $this->listener = new RequestFormatListener();
    }

    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $event = $this->createGetResponseEvent(HttpKernelInterface::SUB_REQUEST);

        $this->listener->onKernelRequest($event);

        $this->assertSame('html', $this->request->getRequestFormat());
    }

    /**
     * @test
     */
    public function formatIsSettled()
    {
        $event = $this->createGetResponseEvent(HttpKernelInterface::SUB_REQUEST);
        $this->request->headers->set('Accept', 'application/json');
        $this->request->setRequestFormat('json');

        $this->listener->onKernelRequest($event);

        $this->assertSame('json', $this->request->getRequestFormat());
    }

    /**
     * @param int $requestType
     *
     * @return GetResponseEvent
     */
    private function createGetResponseEvent(int $requestType): GetResponseEvent
    {
        return new GetResponseEvent($this->kernel, $this->request, $requestType);
    }
}
