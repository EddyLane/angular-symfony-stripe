<?php

namespace spec\UVd\UserBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use UVd\PaymentBundle\Entity\Card;

class CardSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\UserBundle\Entity\Card');
    }

    function it_should_have_the_last_four_digits_of_a_credit_debit_card()
    {
        $this->setNumber(1234);
        $this->getNumber()->shouldReturn('1234');
    }

    /**
     * @param \UVd\UserBundle\Entity\User $user
     */
    function it_should_be_related_to_a_user($user)
    {
        $this->setUser($user);
        $this->getUser($user)->shouldReturn($user);
    }


    function it_should_have_a_card_type($user)
    {
        $this->setCardTye(Card)
    }
}
