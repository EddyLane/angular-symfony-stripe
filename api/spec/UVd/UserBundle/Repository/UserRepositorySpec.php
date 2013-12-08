<?php

namespace spec\UVd\UserBundle\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserRepositorySpec extends ObjectBehavior
{
    /**
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Doctrine\ORM\Mapping\ClassMetadata $classMetadata
     */
    function let($em, $classMetadata)
    {
        $this->beConstructedWith($em, $classMetadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\UserBundle\Repository\UserRepository');
    }
}
