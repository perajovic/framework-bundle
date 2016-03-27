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

namespace Filos\FrameworkBundle\Controller;

use Filos\FrameworkBundle\Response\ResponseHeaders;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as TwigExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends TwigExceptionController
{
    /**
     * {inheritdoc}.
     */
    public function showAction(
        Request $request,
        FlattenException $exception,
        DebugLoggerInterface $logger = null
    ) {
        //always enforce non-debug mode
        $this->debug = false;

        $response = parent::showAction($request, $exception, $logger);

        $response->setStatusCode($exception->getStatusCode());
        $response->headers->set(ResponseHeaders::ERROR_HANDLED_HEADER, true);

        return $response;
    }
}
