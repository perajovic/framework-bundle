<?php

namespace Filos\FrameworkBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestFormatListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $format = $request->getFormat($request->headers->get('Accept'));
        $request->setRequestFormat($format);
    }
}
