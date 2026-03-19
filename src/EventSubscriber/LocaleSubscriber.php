<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        if ($locale = $request->query->get('lang')) {
            $session->set('_locale', $locale);

            $request->setLocale($session->get('_locale', $request->getDefaultLocale()));

            $cleanUrl = strtok($request->getUri(), '?');

            $event->setResponse(new RedirectResponse($cleanUrl));
        }

        // set session or default
        $request->setLocale($session->get('_locale', $request->getDefaultLocale()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
