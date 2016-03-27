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

use Filos\FrameworkBundle\EventListener\ResponseDecoratorListener;
use Filos\FrameworkBundle\Response\Headers;
use Filos\FrameworkBundle\Test\EventListenerTestCase;

class ResponseDecoratorListenerTest extends EventListenerTestCase
{
    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $this->ensureIsNotMasterRequest();

        $this->listener->onKernelResponse($this->event);
    }

    /**
     * @test
     */
    public function listenerIsStoppedForRequestWithoutAppConfig()
    {
        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureResponse();

        $this->listener->onKernelResponse($this->event);
    }

    /**
     * @test
     */
    public function cacheIsConfiguredForRequestWithAppConfig()
    {
        $attributes = ['_app' => [Headers::RESPONSE_STATUS_KEY => 200]];

        $this->request->attributes->replace($attributes);

        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureResponse();

        $this->listener->onKernelResponse($this->event);

        $this->assertSame(
            'must-revalidate, no-cache, no-store, post-check=0, pre-check=0, private',
            $this->response->headers->get('cache-control')
        );
        $this->assertSame('no-cache', $this->response->headers->get('Pragma'));
    }

    /**
     * @test
     * @dataProvider provideSkippedHeaders
     */
    public function appHeadersAreNotSettled($attributes)
    {
        if ($attributes) {
            $this->request->attributes->replace($attributes);
        }

        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureResponse();

        $this->listener->onKernelResponse($this->event);
    }

    /**
     * @test
     * @dataProvider provideResponseStatus
     */
    public function responseStatus($isResponseStatusSettled)
    {
        $attributes = $isResponseStatusSettled
            ? ['_app' => [Headers::RESPONSE_STATUS_KEY => 200]]
            : [];

        $this->request->attributes->replace($attributes);

        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureResponse();

        $this->listener->onKernelResponse($this->event);

        if ($isResponseStatusSettled) {
            $this->assertSame(200, $this->response->getStatusCode());
        }
    }

    /**
     * @test
     */
    public function pageHeadersAreNotSettledForAjaxRequest()
    {
        $attributes = ['_app' => [Headers::PAGE_TITLE_KEY => 'foo']];

        $this->request->attributes->replace($attributes);
        $this->request->headers->set('X-Requested-With', false);

        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureResponse();

        $this->listener->onKernelResponse($this->event);
    }

    /**
     * @test
     * @dataProvider provideAppConfig
     */
    public function responseStatusCodeAndPageHeaders($hasAppConfig)
    {
        $attributes = $hasAppConfig
            ? [
                '_app' => [
                    Headers::RESPONSE_STATUS_KEY => 200,
                    Headers::PAGE_TITLE_KEY => 'Foo',
                    Headers::ACTION_CALLBACK_KEY => 'foo:bar',
                    Headers::ACTION_DATA_KEY => ['foo' => 'bar'],
                ],
            ]
            : [
                '_app' => [],
            ];

        $this->request->attributes->replace($attributes);
        $this->request->headers->set('X-Requested-With', true);

        $this->ensureIsMasterRequest();
        $this->ensureRequest();
        $this->ensureResponse();

        $this->listener->onKernelResponse($this->event);

        if ($hasAppConfig) {
            $this->assertSame(200, $this->response->getStatusCode());
            $this->assertSame(
                '"Foo"',
                $this->response->headers->get(Headers::PAGE_TITLE_HEADER)
            );
            $this->assertSame(
                'foo:bar',
                $this->response->headers->get(Headers::ACTION_CALLBACK_HEADER)
            );
            $this->assertSame(
                json_encode(['foo' => 'bar']),
                $this->response->headers->get(Headers::ACTION_DATA_HEADER)
            );
        }
    }

    public function provideSkippedHeaders()
    {
        return [
            [null],
            [['_app' => [Headers::RESPONSE_STATUS_KEY => 200]]],
        ];
    }

    public function provideAppConfig()
    {
        return [
            [false],
            [true],
        ];
    }

    public function provideResponseStatus()
    {
        return [
            [false],
            [true],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->request = $this->createRequest();
        $this->response = $this->createResponse();
        $this->event = $this->createFilterResponseEvent();
        $this->listener = new ResponseDecoratorListener();
    }
}
