<?php

namespace spec\UVd\PaymentBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserManagerSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('UVd\PaymentBundle\Entity\User');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Manager\UserManager');
    }
}
