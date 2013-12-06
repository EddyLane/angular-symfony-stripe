<?php

namespace UVd\PaymentBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\SecurityContextInterface;
use UVd\PaymentBundle\Controller\BaseController;
/**
 * @author Matt Drollette <matt@drollette.com>
 */
class BeforeControllerListener
{

    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            // not a object but a different kind of callable. Do nothing
            return;
        }

        $controllerObject = $controller[0];

        if ($controllerObject instanceof BaseController) {
            // this method is the one that is part of the interface.
            $controllerObject->initialize($event->getRequest(), $this->securityContext);
        }
    }
}