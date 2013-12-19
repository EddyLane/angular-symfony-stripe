<?php

namespace UVd\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use UVd\PaymentBundle\Entity\Payment;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ORM\Entity
 * @ORM\Table(name="uvd_user")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="stripe_id", type="string", nullable=true, options={"default":null})
     */
    protected $stripeId;

    /**
     * @ORM\OneToMany(targetEntity="UVd\PaymentBundle\Entity\Payment", mappedBy="user", cascade={"all"})
     *
     * @var ArrayCollection $payments
     */
    protected $payments;

    /**
     * @ORM\OneToMany(targetEntity="UVd\PaymentBundle\Entity\Card", mappedBy="user", cascade={"all"})
     * @Expose
     * @var ArrayCollection $cards
     */
    protected $cards;


    public function __construct()
    {
        parent::__construct();
        $this->cards = new ArrayCollection();
    }

    /**
     * @param Payment $payment
     * @return $this
     */
    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * @return String
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * @param $stripeId
     * @return $this
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername() . '(' . $this->getEmail() . ')';
    }

    /**
     * @return ArrayCollection
     */
    public function getCards()
    {
        return $this->cards;
    }

}