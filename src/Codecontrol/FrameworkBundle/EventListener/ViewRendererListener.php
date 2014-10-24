<?php

namespace Codecontrol\FrameworkBundle\EventListener;

use Codecontrol\FrameworkBundle\Controller\ControllerResult;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Templating\EngineInterface;

class ViewRendererListener
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
            $content = $this->templating->render($template, $result->view->all());
        }

        $event->setResponse(new Response($content));
    }
}
