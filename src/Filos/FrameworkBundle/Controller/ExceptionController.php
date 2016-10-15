<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Controller;

use Filos\FrameworkBundle\Http\ResponseHeaders;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as TwigExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Twig_Environment;

final class ExceptionController extends TwigExceptionController
{
    /**
     * {@inheritdoc}.
     */
    public function __construct(Twig_Environment $twig, bool $debug = false)
    {
        parent::__construct($twig, $debug);
    }

    /**
     * {@inheritdoc}.
     */
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        $request->attributes->get('showException', true);

        $response = parent::showAction($request, $exception, $logger);

        $response->setStatusCode($exception->getStatusCode());
        $response->headers->set(ResponseHeaders::ERROR_HANDLED_HEADER, true);

        return $response;
    }
}
