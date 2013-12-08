<?php

namespace spec\UVd\UserBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserManagerSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('UVd\UserBundle\Entity\User');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\UserBundle\Manager\UserManager');
    }
}
