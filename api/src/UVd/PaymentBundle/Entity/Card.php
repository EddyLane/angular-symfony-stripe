<?php

namespace UVd\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UVd\UserBundle\Entity\User;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Card
{
    const CARD_TYPE_VISA = 1;
    const CARD_TYPE_MASTERCARD = 2;
    const CARD_TYPE_AMERICAN_EXPRESS = 3;

//    const CARD_FORMAT_VISA = '**** **** **** %s';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Expose
     * @Accessor(getter="getNumber")
     * @ORM\Column(name="number", type="string", length=4)
     */
    private $number;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="card_type", type="smallint")
     */
    private $cardType;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="exp_month", type="integer")
     */
    private $expMonth;

    /**
     * @var integer
     *
     * @Expose
     * @ORM\Column(name="exp_year", type="integer")
     */
    private $expYear;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UVd\UserBundle\Entity\User", inversedBy="cards")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="UVd\PaymentBundle\Entity\Payment", mappedBy="card", cascade={"all"})
     *
     * @var ArrayCollection $payments
     */
    protected $payments;


    /**
     * @param $type
     * @return int
     */
    public static function mapCardType($type)
    {
        switch(strtolower($type)) {
            case 'visa':
                return self::CARD_TYPE_VISA;
            case 'american express':
                return self::CARD_TYPE_AMERICAN_EXPRESS;
            case 'mastercard':
                return self::CARD_TYPE_MASTERCARD;
        }
    }
//
//    public static function mapCardFormat($type)
//    {
//        switch($type) {
//            case self::CARD_TYPE_VISA:
//                return self::CARD_FORMAT_VISA;
//        }
//    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Card
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->getNumber();
//        $format = self::mapCardFormat($this->getCardType());
//        return $format;
//        return sprintf($format, $this->getNumber());
    }

    /**
     * Set cardType
     *
     * @param integer $cardType
     * @return Card
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;

        return $this;
    }

    /**
     * Get cardType
     *
     * @return integer 
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param $expMonth
     * @return $this
     */
    public function setExpMonth($expMonth)
    {
        $this->expMonth = $expMonth;

        return $this;
    }

    /**
     * @param $expYear
     * @return $this
     */
    public function setExpYear($expYear)
    {
        $this->expYear = $expYear;

        return $this;
    }
}
