<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Templating\EngineInterface;

final class ViewRendererListener
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
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

        $content = '';
        $template = $result->app->get('page_template');
        if ($template) {
            $content = trim($this->templating->render($template, $result->view->all()));
        }

        $event->setResponse(new Response($content));
    }
}
