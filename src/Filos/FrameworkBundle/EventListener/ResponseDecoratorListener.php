<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Http\ResponseHeaders;
use Filos\FrameworkBundle\Utils\Escaper;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

final class ResponseDecoratorListener
{
    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param Escaper $escaper
     */
    public function __construct(Escaper $escaper)
    {
        $this->escaper = $escaper;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();
        $headers = $response->headers;
        $app = $request->attributes->get('_app');

        if (!is_array($app)) {
            return;
        }

        if (true === $headers->get(ResponseHeaders::ERROR_HANDLED_HEADER)) {
            return;
        }

        if (isset($app['no_cache']) && true === (bool) $app['no_cache']) {
            $this->enforceNoCache($headers);
        }

        $this->setStatusCode($app, $response);

        if (!$request->isXmlHttpRequest()) {
            return;
        }

        $this->setPageTitle($app, $headers);
        $this->setActionCallback($app, $headers);
        $this->setActionData($app, $headers);
    }

    /**
     * @param array    $app
     * @param Response $response
     */
    private function setStatusCode(array $app, Response $response)
    {
        if (isset($app[ResponseHeaders::RESPONSE_STATUS_KEY])) {
            $response->setStatusCode($app[ResponseHeaders::RESPONSE_STATUS_KEY]);
        }
    }

    /**
     * @param array             $app
     * @param ResponseHeaderBag $headers
     */
    private function setPageTitle(array $app, ResponseHeaderBag $headers)
    {
        if (isset($app[ResponseHeaders::PAGE_TITLE_KEY])) {
            $headers->set(
                ResponseHeaders::PAGE_TITLE_HEADER,
                $this->getDecodedString($app[ResponseHeaders::PAGE_TITLE_KEY])
            );
        }
    }

    /**
     * @param array             $app
     * @param ResponseHeaderBag $headers
     */
    private function setActionCallback(array $app, ResponseHeaderBag $headers)
    {
        if (isset($app[ResponseHeaders::ACTION_CALLBACK_KEY])) {
            $headers->set(ResponseHeaders::ACTION_CALLBACK_HEADER, $app[ResponseHeaders::ACTION_CALLBACK_KEY]);
        }
    }

    /**
     * @param array             $app
     * @param ResponseHeaderBag $headers
     */
    private function setActionData(array $app, ResponseHeaderBag $headers)
    {
        if (isset($app[ResponseHeaders::ACTION_DATA_KEY])) {
            $headers->set(
                ResponseHeaders::ACTION_DATA_HEADER,
                $this->getDecodedString($app[ResponseHeaders::ACTION_DATA_KEY])
            );
        }
    }

    /**
     * @param HeaderBag $headers
     */
    private function enforceNoCache(HeaderBag $headers)
    {
        $headers->set(
            'cache-control',
            'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            false
        );
        $headers->set('Pragma', 'no-cache', false);
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    private function getDecodedString($data): string
    {
        return json_encode($this->escaper->escape($data));
    }
}
