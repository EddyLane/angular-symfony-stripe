<?php

namespace UVd\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Gedmo\Mapping\Annotation\Timestampable;
use UVd\UserBundle\Entity\User;

/**
 * Payment
 *
 * @ORM\Table("uvd_payment")
 * @ORM\Entity(repositoryClass="UVd\PaymentBundle\Repository\PaymentRepository")
 *
 * @ExclusionPolicy("all")
 */
class Payment
{
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
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @param \UVd\UserBundle\Entity\User $card
     */
    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return \UVd\UserBundle\Entity\User
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param \UVd\SubscriptionBundle\Entity\Subscription $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return \UVd\SubscriptionBundle\Entity\Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UVd\UserBundle\Entity\User", inversedBy="payments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $user;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UVd\PaymentBundle\Entity\Card", inversedBy="payments", cascade={"all"})
     * @ORM\JoinColumn(name="card_id", referencedColumnName="id", nullable=true)
     */
    protected $card;

    /**
     * @var \UVd\SubscriptionBundle\Entity\Subscription
     *
     * @ORM\ManyToOne(targetEntity="UVd\SubscriptionBundle\Entity\Subscription", inversedBy="payments", cascade={"all"})
     * @ORM\JoinColumn(name="subscription_id", referencedColumnName="id", nullable=false)
     */
    protected $subscription;

    /**
     * @var datetime $created
     *
     * @Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean", nullable=true)
     * @Expose
     */
    private $completed;

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
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if(is_null($data)) {
            return;
        }

        $this->completed = false;
        $this->setToken($data['token']);
        $this->setUser($data['user']);
    }

    /**
     * Is this valid
     *
     * @return bool
     */
    public function isValid()
    {
        $validUser = !is_null($this->getUser());

        $validToken = !is_null($this->getToken());

        return $validUser && $validToken;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Payment
     * @throws \Exception
     */
    public function setToken($token)
    {
        if(!is_string($token)) {
            throw new \InvalidArgumentException(sprintf('Token must be a string. %s given', $token));
        }

        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UVd\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Sets the success of this payment
     *
     * @param $completed
     * @return $this
     * @throws \Exception
     */
    public function setCompleted($completed)
    {
        if(!is_bool($completed)) {
            throw new \InvalidArgumentException(sprintf('Completed must be a boolean. \'%s\' given', $completed));
        }

        $this->completed = $completed;

        return $this;
    }

    /**
     * Get the success of this payment
     *
     * @return bool
     */
    public function getCompleted()
    {
        return $this->completed;
    }



}
