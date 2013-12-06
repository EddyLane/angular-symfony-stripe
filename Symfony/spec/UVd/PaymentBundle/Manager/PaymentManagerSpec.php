<?php

namespace spec\UVd\PaymentBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentManagerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('UVd\PaymentBundle\Entity\Payment');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Manager\PaymentManager');
    }
}
