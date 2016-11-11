<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Interceptor;

use Symfony\Component\HttpFoundation\Request;
use RuntimeException;

final class InterceptorManager
{
    /**
     * @var array
     */
    private $interceptors;

    public function __construct(array $interceptors = [])
    {
        $this->setInterceptors($interceptors);
    }

    public function setInterceptors(array $interceptors)
    {
        foreach ($interceptors as $name => $interceptor) {
            $this->addInterceptor($name, $interceptor);
        }
    }

    public function addInterceptor($name, InterceptorInterface $interceptor)
    {
        $this->interceptors[$name] = $interceptor;
    }

    /**
     * @throws RuntimeException
     */
    public function handle(Request $request)
    {
        $app = $request->attributes->get('_app', []);
        $interceptors = $app['interceptors'] ?? [];

        foreach ($interceptors as $value) {
            if (!isset($this->interceptors[$value])) {
                throw new RuntimeException(sprintf(
                    'Interceptor "%s" for route "%s" not found.',
                    $value,
                    $request->attributes->get('_route')
                ));
            }

            $this->interceptors[$value]->apply($request);
        }
    }
}
