<?php

namespace spec\UVd\PaymentBundle\Controller;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentControllerSpec extends ObjectBehavior
{
    /**
     * Set up
     *
     * @param \Symfony\Component\DependencyInjection\Container $container
     *
     * @param \UVd\PaymentBundle\Manager\PaymentManager $paymentManager
     * @param \UVd\PaymentBundle\Provider\StripeProvider $stripeProvider
     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $tokenInterface
     * @param \UVd\UserBundle\Entity\User $user
     */
    function let($container, $paymentManager, $stripeProvider, $securityContext, $tokenInterface, $user)
    {
        //Set up the dependency injection.
        $container
            ->get('uvd.payment.payment_manager')
            ->willReturn($paymentManager)
        ;

        $container
            ->get('uvd.payment.stripe_provider')
            ->willReturn($stripeProvider)
        ;

        $container
            ->has('security.context')
            ->willReturn(true)
        ;

        $container
            ->get('security.context')
            ->willReturn($securityContext)
        ;

        $this->setContainer($container);


        //Set up security
        $securityContext
            ->getToken()
            ->willReturn($tokenInterface)
        ;

        $tokenInterface
            ->getUser()
            ->willReturn($user)
        ;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Controller\PaymentController');
        $this->shouldBeAnInstanceOf('UVd\PaymentBundle\Controller\BaseController');
    }

    /**
     * @param \FOS\RestBundle\Request\ParamFetcher $paramFetcher
     * @param \UVd\PaymentBundle\Manager\PaymentManager $paymentManager
     * @param \UVd\PaymentBundle\Provider\StripeProvider $stripeProvider
     * @param \UVd\UserBundle\Entity\User $user
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     */
    function it_should_create_and_persist_a_payment_object_with_the_authenticated_user(
        $paramFetcher,
        $paymentManager,
        $stripeProvider,
        $user,
        $payment
    )
    {
        $requestParameters = [
            'token' => 123456789
        ];

        $paramFetcher
            ->all()
            ->shouldBeCalled()
            ->willReturn($requestParameters)
        ;

        $paymentParameters = [
            'token' => 123456789,
            'user' => $user
        ];

        $paymentManager
            ->create($paymentParameters)
            ->shouldBeCalled()
            ->willReturn($payment)
        ;

        $stripeProvider
            ->create($payment)
            ->shouldBeCalled()
        ;

        $paymentManager
            ->save($payment, true)
            ->shouldBeCalled()
        ;

        $this
            ->postPayAction($paramFetcher)
            ->shouldReturn($payment)
        ;
    }

}
