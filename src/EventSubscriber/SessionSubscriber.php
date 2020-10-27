<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SessionSubscriber implements EventSubscriberInterface
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

        $lastUsed = $request->getSession()->getMetadataBag()->getLastUsed();
        $lifetime = $request->getSession()->getMetadataBag()->getLifetime();
        if (time() > $lastUsed + $lifetime) {
            $request->getSession()->clear();
        }
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
