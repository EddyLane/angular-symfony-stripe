<?php

namespace spec\UVd\PaymentBundle\Proxy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StripeProxySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Proxy\StripeProxy');
    }
}
