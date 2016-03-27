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

use Filos\FrameworkBundle\Controller\ControllerResult;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class RouteAppListener
{
    /**
     * @var array
     */
    private $appDefaults;

    /**
     * @param array $appDefaults
     */
    public function __construct(array $appDefaults = [])
    {
        $this->appDefaults = $appDefaults;
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $result = $event->getControllerResult();

        if (!($result instanceof ControllerResult)) {
            return;
        }

        $attributes = $event->getRequest()->attributes;

        $app = array_replace(
            $this->appDefaults,
            $attributes->get('_app', []),
            $result->app->all()
        );

        $result->app->replace($app);
        $attributes->set('_app', $app);
    }
}
