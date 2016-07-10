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

use Filos\FrameworkBundle\EventListener\ResponseDecoratorListener;
use Filos\FrameworkBundle\Utils\Escaper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class ResponseDecoratorListenerTest extends TestCase
{
    /**
     * @var FilterResponseEvent
     */
    private $event;

    /**
     * @var AppKernel
     */
    private $kernel;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var ResponseDecoratorListener
     */
    private $listener;

    public function setUp()
    {
        parent::setUp();

        $this->kernel = new AppKernel('test', true);
        $this->request = Request::create('/_listener');
        $this->response = new Response();
        $this->event = $this->createFilterResponseEvent(HttpKernelInterface::MASTER_REQUEST);
        $this->listener = new ResponseDecoratorListener(new Escaper());
    }

    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $this->request->attributes->set('_app', ['response_status' => 201]);

        $event = $this->createFilterResponseEvent(HttpKernelInterface::SUB_REQUEST);

        $this->listener->onKernelResponse($event);

        $this->assertSame(200, $this->response->getStatusCode());
    }

    /**
     * @test
     */
    public function listenerIsStoppedForRequestWithoutAppConfig()
    {
        $this->listener->onKernelResponse($this->event);
    }

    /**
     * @test
     */
    public function ifErrorIsHandledSomeResponseDecorationIsSkipped()
    {
        $this->request->attributes->set('_app', ['response_status' => 201]);
        $this->response->headers->set('X-Error-Handled', true);

        $this->listener->onKernelResponse($this->event);

        $this->assertSame(200, $this->response->getStatusCode());
    }

    /**
     * @test
     */
    public function cacheIsConfigured()
    {
        $attributes = ['_app' => ['response_status' => 200, 'no_cache' => true]];

        $this->request->attributes->replace($attributes);

        $this->listener->onKernelResponse($this->event);

        $this->assertSame(
            'must-revalidate, no-cache, no-store, post-check=0, pre-check=0, private',
            $this->response->headers->get('cache-control')
        );
        $this->assertSame('no-cache', $this->response->headers->get('Pragma'));
    }

    /**
     * @test
     */
    public function newResponseStatusCodeIsSettled()
    {
        $this->request->attributes->set('_app', ['response_status' => 201]);

        $this->listener->onKernelResponse($this->event);

        $this->assertSame(201, $this->response->getStatusCode());
    }

    /**
     * @test
     */
    public function pageHeadersAreNotSettledForAjaxRequest()
    {
        $attributes = ['_app' => ['page_title' => 'foo']];

        $this->request->attributes->replace($attributes);
        $this->request->headers->set('X-Requested-With', false);

        $this->listener->onKernelResponse($this->event);

        $this->assertNull($this->response->headers->get('page_title'));
    }

    /**
     * @test
     */
    public function allHeadersAreSettled()
    {
        $attributes = [
            '_app' => [
                'response_status' => 200,
                'page_title' => 'Foo',
                'action_callback' => 'foo:bar',
                'action_data' => ['foo' => 'bar'],
            ],
        ];

        $this->request->attributes->replace($attributes);
        $this->request->headers->set('X-Requested-With', true);

        $this->listener->onKernelResponse($this->event);

        $this->assertSame(200, $this->response->getStatusCode());
        $this->assertSame('"Foo"', $this->response->headers->get('X-Page-Title'));
        $this->assertSame('foo:bar', $this->response->headers->get('X-Action-Callback'));
        $this->assertSame(json_encode(['foo' => 'bar']), $this->response->headers->get('X-Action-Data'));
    }

    /**
     * @param int $requestType
     *
     * @return FilterResponseEvent
     */
    private function createFilterResponseEvent(int $requestType): FilterResponseEvent
    {
        return new FilterResponseEvent($this->kernel, $this->request, $requestType, $this->response);
    }
}
