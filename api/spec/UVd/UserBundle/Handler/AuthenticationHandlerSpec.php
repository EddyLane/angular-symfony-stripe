<?php

namespace spec\UVd\UserBundle\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthenticationHandlerSpec extends ObjectBehavior
{

    /**
     * @param \FOS\RestBundle\View\ViewHandler $viewHandler
     */
    function let($viewHandler)
    {
        $this->beConstructedWith($viewHandler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\UserBundle\Handler\AuthenticationHandler');
    }
}
