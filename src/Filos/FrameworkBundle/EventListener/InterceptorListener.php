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
