<?php

namespace spec\UVd\PaymentBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UVdPaymentBundleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\UVdPaymentBundle');
    }
}
