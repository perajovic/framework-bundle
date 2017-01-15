<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Interceptor\InterceptorManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

final class InterceptorListener
{
    /**
     * @var InterceptorManager
     */
    private $manager;

    public function __construct(InterceptorManager $manager)
    {
        $this->manager = $manager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $app = $request->attributes->get('_app');

        if (isset($app['interceptors'])) {
            $this->manager->handle($request);
        }
    }
}
