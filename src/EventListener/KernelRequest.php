<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class KernelRequest
{
    public function onKernelRequest(RequestEvent $event, Request $request)
    {
        $eventRequest = $event->getRequest();
        $locale = $request->getLocale();
        // some logic to determine the $locale
        $eventRequest->setLocale($locale);
    }
}