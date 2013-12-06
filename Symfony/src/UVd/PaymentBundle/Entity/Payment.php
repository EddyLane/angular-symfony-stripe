<?php

namespace UVd\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Payment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UVd\PaymentBundle\Entity\PaymentRepository")
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="payments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var type
     */
    protected $user;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean", nullable=true)
     * @Expose
     */
    private $completed = false;

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
        if($data !== null) {
            $this->setToken($data['token']);
            $this->setUser($data['user']);
        }
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
     * @return type
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
