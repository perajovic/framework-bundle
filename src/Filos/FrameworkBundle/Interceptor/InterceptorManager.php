<?php

namespace Filos\FrameworkBundle\Interceptor;

use Symfony\Component\HttpFoundation\Request;
use RuntimeException;

class InterceptorManager
{
    /**
     * @var array
     */
    private $interceptors;

    /**
     * @param array $interceptors
     */
    public function __construct(array $interceptors = [])
    {
        $this->setInterceptors($interceptors);
    }

    /**
     * @param array $interceptors
     */
    public function setInterceptors(array $interceptors)
    {
        foreach ($interceptors as $name => $interceptor) {
            $this->addInterceptor($name, $interceptor);
        }
    }

    /**
     * @param string               $name
     * @param InterceptorInterface $interceptor
     */
    public function addInterceptor($name, InterceptorInterface $interceptor)
    {
        $this->interceptors[$name] = $interceptor;
    }

    /**
     * @param Request $request
     *
     * @throws RuntimeException
     */
    public function handle(Request $request)
    {
        $app = $request->attributes->get('_app', []);
        $interceptors = isset($app['interceptors']) ? $app['interceptors'] : [];

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
