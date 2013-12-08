<?php

namespace UVd\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Card
{
    const CARD_TYPE_VISA = 1;
    const CARD_TYPE_MASTERCARD = 2;
    const CARD_TYPE_AMERICAN_EXPRESS = 3;

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
     * @ORM\Column(name="number", type="string", length=4)
     */
    private $number;

    /**
     * @var integer
     *
     * @ORM\Column(name="card_type", type="smallint")
     */
    private $cardType;

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
        return $this->number;
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
}
