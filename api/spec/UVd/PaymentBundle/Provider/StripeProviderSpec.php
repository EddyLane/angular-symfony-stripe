<?php

namespace spec\UVd\PaymentBundle\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StripeProviderSpec extends ObjectBehavior
{
    /**
     * @param \UVd\PaymentBundle\Proxy\StripeProxy $stripeProxy
     */
    function let($stripeProxy)
    {
        $apiKey = '1234567';

        $stripeProxy
            ->setApiKey($apiKey)
            ->shouldBeCalled()
        ;

        $this->beConstructedWith($stripeProxy, $apiKey);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Provider\StripeProvider');
    }

    /**
     * @param \StdClass $payment
     */
    function it_should_only_allow_you_to_create_a_stripe_charge_from_a_payment_entity($payment)
    {
        $this
            ->shouldThrow('\Exception')
            ->during('create', array($payment))
        ;
        $this
            ->shouldThrow('\Exception')
            ->during('create', array('string'))
        ;
        $this
            ->shouldThrow('\Exception')
            ->during('create', array(12345))
        ;
    }


    /**
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     */
    function it_should_throw_an_error_exception_if_attempting_to_charge_with_a_payment_without_a_user($payment)
    {

        $payment->isValid()->willReturn(false);

        $this
            ->shouldThrow('\ErrorException')
            ->during('create', array($payment))
        ;
    }

    /**
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     */
    function it_should_throw_an_error_exception_if_attempting_to_charge_with_a_payment_without_a_token($payment)
    {
        $payment->isValid()->willReturn(false);


        $this
            ->shouldThrow('\ErrorException')
            ->during('create', array($payment))
        ;
    }

    /**
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     * @param \UVd\PaymentBundle\Proxy\StripeProxy $stripeProxy
     * @param \Stripe_Charge $stripeCharge
     */
    function it_will_attempt_make_a_payment_through_stripe_proxy_if_valid_payment($payment, $stripeProxy, $stripeCharge)
    {
        $token = '123abcdef45';

        $payment->isValid()->willReturn(true);

        $payment
            ->getToken()
            ->willReturn($token)
        ;

        $stripeProxy
            ->createCharge([
                "amount" => 1000,
                "currency" => "usd",
                "card" => $token,
                "description" => "payinguser@example.com"
            ])
            ->shouldBeCalled()
            ->willReturn($stripeCharge)
        ;

        $payment
            ->setCompleted(true)
            ->shouldBeCalled()
        ;

        $this
            ->create($payment)
            ->shouldReturn($stripeCharge)
        ;
    }

}
