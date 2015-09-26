<?php

namespace SupportYard\FrameworkBundle\Interceptor;

use SupportYard\FrameworkBundle\Request\AppRequestInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AppRequestInterceptor implements InterceptorInterface
{
    /**
     * @var AppRequestInterface
     */
    private $appRequest;

    public function __construct(AppRequestInterface $appRequest)
    {
        $this->appRequest = $appRequest;
    }

    /**
     * @param Request $request
     *
     * @throws BadRequestHttpException
     */
    public function apply(Request $request)
    {
        $this->appRequest->populateFields($request);

        if (!$this->appRequest->isValid()) {
            throw new BadRequestHttpException($this->appRequest->getFlattenErrors());
        }

        $request->attributes->set('appRequest', $this->appRequest);
    }
}
