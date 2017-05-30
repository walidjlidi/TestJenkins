<?php

namespace UserBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AccesGrant
{

    protected $container;

    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public function grant(GetResponseEvent $event)
    {
        $request = $event->getRequest();
       
        $routeName = $request->get("_route");

        if ($event->getRequestType() == \Symfony\Component\HttpKernel\Kernel::SUB_REQUEST)
        {
            return;
        }

        if ($this->container->get('security.token_storage')->getToken() != null)
        {
            if ($this->container->get('security.token_storage')->getToken()->getRoles())
            {
                {
                    if ($this->container->get('security.authorization_checker')->isGranted(null,$routeName) == false)
                    {
                      throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
                    }
                }
            }
        }
    }

}
