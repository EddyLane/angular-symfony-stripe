<?php

namespace spec\UVd\PaymentBundle\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentRepositorySpec extends ObjectBehavior
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
        $this->shouldHaveType('UVd\PaymentBundle\Repository\PaymentRepository');
    }
}
