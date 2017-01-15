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

use Filos\FrameworkBundle\Controller\ControllerResult;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

final class RouteAppListener
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

        $app = array_replace($this->appDefaults, $attributes->get('_app', []), $result->app->all());

        $result->app->replace($app);
        $attributes->set('_app', $app);
    }
}
