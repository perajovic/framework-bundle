<?php

namespace Codecontrol\FrameworkBundle\Controller;

use Codecontrol\FrameworkBundle\Response\ResponseHeaders;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController as TwigExceptionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends TwigExceptionController
{
    /**
     * {inheritedDoc}.
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
