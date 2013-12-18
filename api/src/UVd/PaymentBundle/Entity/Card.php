<?php

namespace UVd\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UVd\UserBundle\Entity\User;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\VirtualProperty;
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
    const CARD_TYPE_DISCOVER = 4;
    const CARD_TYPE_DINERS_CLUB = 5;
    const CARD_TYPE_JCB = 6;

    const CARD_NAME_VISA = 'Visa';
    const CARD_NAME_MASTERCARD = 'Mastercard';

    const CARD_FORMAT_VISA = '**** **** **** ****';
    const CARD_FORMAT_MASTERCARD = '**** **** **** ****';
    const CARD_FORMAT_AMERICAN_EXPRESS = '**** ****** *****';
    const CARD_FORMAT_DISCOVER = '**** **** **** ****';
    const CARD_FORMAT_DINERS_CLUB = '**** **** **** ****';
    const CARD_FORMAT_JCB = '**** **** **** ****';

    /**
     * @var integer
     * @Expose
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
     * @Accessor(getter="getCardType")
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
     * @var string
     * @ORM\Column(name="token", type="string")
     */
    private $token;

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


    public function __construct($token = null)
    {
        if(!is_null($token)) {
            $this->setToken($token);
        }
    }

    /**
     * @param $name
     * @return int
     */
    public static function mapCardType($name)
    {
        switch(strtolower($name)) {
            case 'visa':
                return self::CARD_TYPE_VISA;
            case 'american express':
                return self::CARD_TYPE_AMERICAN_EXPRESS;
            case 'mastercard':
                return self::CARD_TYPE_MASTERCARD;
            default:
                return self::CARD_TYPE_VISA;

        }
    }

    public static function mapCardTypeName($type)
    {
        switch($type) {
            case 1:
                return self::CARD_NAME_VISA;
            case 2:
                return self::CARD_NAME_MASTERCARD;
        }

    }

    public static function mapCardFormat($type)
    {
        switch($type) {
            case 1:
                return self::CARD_FORMAT_VISA;
            case 2:
                return self::CARD_FORMAT_MASTERCARD;
            default:
                return self::CARD_FORMAT_VISA;
        }
    }
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
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
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
        $format = self::mapCardFormat($this->cardType);
        return substr_replace($format, $this->number, - strlen($this->number));
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
     * @VirtualProperty
     * @return string
     */
    public function getCardTypeName()
    {
        return self::mapCardTypeName($this->cardType);
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


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function belongsTo(User $user)
    {
        return $user->getId() === $this->getUser()->getId();
    }
}
