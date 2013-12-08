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

    /**
     * @param \UVd\UserBundle\Entity\User $user
     */
    function it_should_be_valid_if_it__has_a_user_and_a_token($user)
    {
        $this->setUser($user);
        $this->setToken('1245');

        $this->isValid()->shouldReturn(true);
    }

    /**
     * @param \UVd\UserBundle\Entity\User $user
     */
    function it_should_be_invalid_if_no_token($user)
    {
        $this->setUser($user);

        $this->isValid()->shouldReturn(false);
    }

    function it_should_be_invalid_if_no_user()
    {
        $this->setToken('123154');

        $this->isValid()->shouldReturn(false);
    }

    function it_should_be_invalid_if_no_token_or_user()
    {
        $this->isValid()->shouldReturn(false);
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