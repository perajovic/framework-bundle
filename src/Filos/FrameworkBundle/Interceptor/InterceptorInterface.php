<?php

namespace Filos\FrameworkBundle\Interceptor;

use Symfony\Component\HttpFoundation\Request;

interface InterceptorInterface
{
    /**
     * @param Request $request
     */
    public function apply(Request $request);
}