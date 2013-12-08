<?php

namespace spec\UVd\PaymentBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Controller\BaseController');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    function it_should_throw_an_http_exception_if_the_user_is_not_authenticated($request, $securityContext)
    {
        $securityContext
            ->isGranted('IS_AUTHENTICATED_REMEMBERED')
            ->shouldBeCalled()
            ->willReturn(false)
        ;

        $this
            ->shouldThrow('\Symfony\Component\HttpKernel\Exception\HttpException')
            ->during('initialize', array($request, $securityContext))
        ;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     */
    function it_should_not_throw_an_http_exception_if_the_user_is_authenticated($request, $securityContext)
    {
        $securityContext
            ->isGranted('IS_AUTHENTICATED_REMEMBERED')
            ->shouldBeCalled()
            ->willReturn(true)
        ;

        $this->initialize($request, $securityContext);
    }
}
