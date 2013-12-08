<?php

namespace spec\UVd\PaymentBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Entity\Payment');
    }

    /**
     * @param \UVd\UserBundle\Entity\User $user
     */
    function it_should_be_associated_to_one_user($user)
    {
        $this->setUser($user);
        $this->getUser()->shouldReturn($user);

        $this->shouldThrow('\Exception')->during('setUser', array('User Object'));
    }

    function it_should_have_a_stripe_token()
    {
        $this->setToken("123fhg135");
        $this->getToken()->shouldReturn("123fhg135");

        $this->shouldThrow('\InvalidArgumentException')->during('setCompleted', array(123456));
    }

    function it_should_have_a_flag_to_denote_that_that_the_payment_has_been_successfully_completed()
    {
        $this->setCompleted(true);
        $this->getCompleted()->shouldReturn(true);

        $this->shouldThrow('\InvalidArgumentException')->during('setCompleted', array('String'));
    }
}