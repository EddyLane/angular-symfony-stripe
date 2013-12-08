<?php

namespace spec\UVd\UserBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserControllerSpec extends ObjectBehavior
{
    /**
     * Set up
     *
     * @param \Symfony\Component\DependencyInjection\Container $container

     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $tokenInterface
     * @param \UVd\UserBundle\Manager\UserManager $userManager
     * @param \UVd\UserBundle\Entity\User $user
     */
    function let($container, $securityContext, $tokenInterface, $userManager, $user)
    {
        $container
            ->get('security.context')
            ->willReturn($securityContext)
        ;

        $container
            ->get('uvd.payment.user_manager')
            ->willReturn($userManager)
        ;

        $this->setContainer($container);

        //Set up security
        $securityContext
            ->getToken()
            ->willReturn($tokenInterface)
        ;

        $container
            ->has('security.context')
            ->willReturn(true)
        ;

        $tokenInterface
            ->getUser()
            ->willReturn($user)
        ;
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\UserBundle\Controller\UserController');
        $this->beAnInstanceOf('UVd\PaymentBundle\Controller\BaseController');
    }

    /**
     * @param \UVd\UserBundle\Entity\User $user
     */
    function it_should_get_the_currently_authenticated_user($user)
    {
        $this
            ->getMeAction()
            ->shouldReturn($user)
        ;
    }

    /**
     * @param \UVd\UserBundle\Manager\UserManager $userManager
     * @param \UVd\UserBundle\Entity\User $user
     * @param \UVd\UserBundle\Entity\User $repoUser
     */
    function it_should_get_a_user_by_id_only_if_it_the_current_user($userManager, $user, $repoUser)
    {
        $user
            ->getId()
            ->shouldBeCalled()
            ->willReturn(1)
        ;

        $userManager
            ->find(1)
            ->shouldBeCalled()
            ->willReturn($repoUser)
        ;

        $this
            ->getUserAction(1)
            ->shouldReturnAnInstanceOf('UVd\UserBundle\Entity\User')
        ;

    }

    /**
     * @param \UVd\UserBundle\Entity\User $user
     */
    function it_should_throw_an_exception_if_trying_to_get_a_different_user($user)
    {
        $user
            ->getId()
            ->shouldBeCalled()
            ->willReturn(1)
        ;

        $this
            ->shouldThrow('Symfony\Component\HttpKernel\Exception\HttpException')
            ->during('getUserAction', array(2))
        ;

    }

}
