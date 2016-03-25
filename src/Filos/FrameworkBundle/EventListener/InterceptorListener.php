<?php

namespace Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Interceptor\InterceptorManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class InterceptorListener
{
    /**
     * @var InterceptorManager
     */
    private $manager;

    /**
     * @param InterceptorManager $manager
     */
    public function __construct(InterceptorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $app = $request->attributes->get('_app');

        if (!isset($app['interceptors'])) {
            return;
        }

        $this->manager->handle($request);
    }
}
