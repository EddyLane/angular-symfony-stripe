<?php

namespace spec\UVd\PaymentBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Entity\User');
    }

    /**
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     */
    function it_should_add_a_payment_to_a_collection_of_payments($payment)
    {
        $this->addPayment($payment);

        $this->getPayments()->shouldReturn([
            $payment
        ]);
    }

}
