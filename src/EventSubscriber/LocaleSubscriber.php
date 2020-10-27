<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleSubscriber implements EventSubscriberInterface
{
    protected $container;

    /**
     * LocaleSubscriber constructor.
     *
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if ($locale = $request->query->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            if (!$request->getSession()->get('_locale')) {
                $locale = substr($request->headers->get('Accept-Language'), 0, 2);
                $request->getSession()->set('_locale', $locale);
            }
        }

        $request->setLocale($request->getSession()->get('_locale'));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 20)),
        );
    }
}
