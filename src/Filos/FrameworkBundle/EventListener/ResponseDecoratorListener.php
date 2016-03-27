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

namespace Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Response\Headers as Headers;
use Filos\FrameworkBundle\Utils\Escaper;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseDecoratorListener
{
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

        $this->enforceNoCache($headers);

        if (true === $headers->get(Headers::ERROR_HANDLED_HEADER)) {
            return;
        }

        $this->setStatusCodeIfExists($app, $response);

        if (!$request->isXmlHttpRequest()) {
            return;
        }

        $this->setPageTitleIfExists($app, $headers);
        $this->setPageCallbackIfExists($app, $headers);
        $this->setPageDataIfExists($app, $headers);
    }

    /**
     * @param array    $app
     * @param Response $response
     */
    private function setStatusCodeIfExists(array $app, Response $response)
    {
        if (isset($app[Headers::RESPONSE_STATUS_KEY])) {
            $response->setStatusCode($app[Headers::RESPONSE_STATUS_KEY]);
        }
    }

    /**
     * @param array             $app
     * @param ResponseHeaderBag $headers
     */
    private function setPageTitleIfExists(array $app, ResponseHeaderBag $headers)
    {
        if (isset($app[Headers::PAGE_TITLE_KEY])) {
            $headers->set(
                Headers::PAGE_TITLE_HEADER,
                json_encode(Escaper::escape($app[Headers::PAGE_TITLE_KEY]))
            );
        }
    }

    /**
     * @param array             $app
     * @param ResponseHeaderBag $headers
     */
    private function setPageCallbackIfExists(array $app, ResponseHeaderBag $headers)
    {
        if (isset($app[Headers::ACTION_CALLBACK_KEY])) {
            $headers->set(
                Headers::ACTION_CALLBACK_HEADER,
                $app[Headers::ACTION_CALLBACK_KEY]
            );
        }
    }

    /**
     * @param array             $app
     * @param ResponseHeaderBag $headers
     */
    private function setPageDataIfExists(array $app, ResponseHeaderBag $headers)
    {
        if (isset($app[Headers::ACTION_DATA_KEY])) {
            $headers->set(
                Headers::ACTION_DATA_HEADER,
                json_encode(Escaper::escape($app[Headers::ACTION_DATA_KEY]))
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
}
