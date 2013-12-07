<?php

namespace spec\UVd\UserBundle\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthenticationHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\UserBundle\Handler\AuthenticationHandler');
    }
}
