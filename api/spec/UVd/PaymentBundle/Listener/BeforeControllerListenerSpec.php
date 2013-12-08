<?php

namespace spec\UVd\PaymentBundle\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BeforeControllerListenerSpec extends ObjectBehavior
{
    /**
     * @param \Symfony\Component\Security\Core\SecurityContext $context
     */
    function let($context)
    {
        $this->beConstructedWith($context);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Listener\BeforeControllerListener');
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $filterControllerEvent
     * @param \UVd\PaymentBundle\Controller\PaymentController $paymentController
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\SecurityContext $context
     */
    function it_should_call_the_initialise_method_on_controllers_that_extend_base_controller(
        $filterControllerEvent,
        $paymentController,
        $request,
        $context
    )
    {
        $filterControllerEvent
            ->getController()
            ->willReturn([$paymentController])
        ;

        $filterControllerEvent
            ->getRequest()
            ->willReturn($request)
        ;

        $paymentController
            ->initialize($request, $context)
            ->shouldBeCalled()
        ;

        $this->onKernelController($filterControllerEvent);
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $filterControllerEvent
     * @param \UVd\PaymentBundle\Controller\PaymentController $paymentController
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\SecurityContext $context
     */
    function it_should_not_call_initialise_if_the_controller_is_not_in_an_array(
        $filterControllerEvent,
        $paymentController,
        $request,
        $context
    )
    {
        $filterControllerEvent
            ->getController()
            ->willReturn($paymentController)
        ;

        $paymentController
            ->initialize($request, $context)
            ->shouldNotBeCalled()
        ;

        $this->onKernelController($filterControllerEvent);
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $filterControllerEvent
     * @param \Symfony\Bundle\FrameworkBundle\Controller\Controller $controller
     */
    function it_should_not_call_initialise_if_the_controller_is_not_extending_base_controller(
        $filterControllerEvent,
        $controller
    )
    {

        $filterControllerEvent
            ->getController()
            ->willReturn($controller)
        ;

        $this->onKernelController($filterControllerEvent);
    }

}