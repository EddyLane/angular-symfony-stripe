<?php

namespace spec\UVd\PaymentBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentManagerSpec extends ObjectBehavior
{

    /**
     * @param \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
     * @param \Doctrine\ORM\EntityManager $em
     */
    function let($doctrine, $em)
    {
        $doctrine
            ->getManager()
            ->willReturn($em)
        ;

        $this->beConstructedWith('UVd\PaymentBundle\Entity\Payment');

        $this->setDoctrine($doctrine);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UVd\PaymentBundle\Manager\PaymentManager');
        $this->shouldBeAnInstanceOf('UVd\PaymentBundle\Manager\BaseManager');
    }


    function it_should_create_instances_of_the_payment_type()
    {
        $this
            ->create()
            ->shouldReturnAnInstanceOf('UVd\PaymentBundle\Entity\Payment')
        ;
    }

    /**
     * @param \UVd\PaymentBundle\Entity\User $user
     */
    function it_should_create_a_payment_entity_and_pass_args_to_its_constructor($user)
    {
        $payment = $this->create([
            'token' => '1251957',
            'user' => $user
        ]);

        $payment
            ->getToken()
            ->shouldReturn('1251957')
        ;

        $payment
            ->getUser()
            ->shouldReturn($user)
        ;
    }

    /**
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     * @param \Doctrine\ORM\EntityManager $em
     */
    function it_should_persist_a_payment_entity_and_flush($payment, $em)
    {
        $em
            ->persist($payment)
            ->shouldBeCalled()
        ;

        $em
            ->flush()
            ->shouldBeCalled()
        ;

        $this->save($payment);
    }

    /**
     * @param \UVd\PaymentBundle\Entity\Payment $payment
     * @param \Doctrine\ORM\EntityManager $em
     */
    function it_should_persist_a_payment_entity_and__not_flush($payment, $em)
    {
        $em
            ->persist($payment)
            ->shouldBeCalled()
        ;

        $em
            ->flush()
            ->shouldNotBeCalled()
        ;

        $this->save($payment, false);
    }
}
