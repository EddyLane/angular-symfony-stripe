<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 17/12/2013
 * Time: 21:21
 */

namespace UVd\PaymentBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UVd\PaymentBundle\Entity\Card;
use Symfony\Component\DependencyInjection\Container;
use UVd\PaymentBundle\Exception\CardDeclinedException;
use UVd\PaymentBundle\Proxy\StripeProxy;
use UVd\UserBundle\Entity\User;

/**
 * Class StripeListenerPrePersist
 * @package UVd\PaymentBundle\Listener
 */
class StripeListenerPrePersist
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * @var \UVd\PaymentBundle\Proxy\StripeProxy
     */
    protected $stripeProxy;

    /**
     * @param Container $container
     * @param StripeProxy $stripeProxy
     */
    public function __construct(Container $container, StripeProxy $stripeProxy)
    {
        $this->container = $container;
        $this->stripeProxy = $stripeProxy;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Card) {

            if(!$this->getUser()->getStripeId()) {
                $this->createUser($this->getUser());
            }

            $this->createCard($entity);
        }
    }

    /**
     * @param User $user
     * @throws \UVd\PaymentBundle\Exception\CardDeclinedException
     */
    protected function createUser(User $user)
    {
        try {

            $parameters = [
                'description' => (String) $user
            ];

            $customerData = $this
                ->stripeProxy
                ->createCustomer($parameters)
            ;

            $user->setStripeId($customerData['id']);

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

        }
        catch(\Stripe_CardError $e) {
            throw new CardDeclinedException($e->getMessage());
        }
    }

    /**
     * @param Card $card
     * @throws \UVd\PaymentBundle\Exception\CardDeclinedException
     */
    protected function createCard(Card $card)
    {
        try {

            $customer = $this
                ->stripeProxy
                ->retrieveCustomer($this->getUser()->getStripeId())
            ;

            (array) $cardData = $customer
                ->cards
                ->create([ 'card' => $card->getToken() ])
            ;

            $card
                ->setUser($this->getUser())
                ->setToken($cardData['id'])
                ->setUser($this->getUser())
                ->setCardType(Card::mapCardType($cardData['type']))
                ->setNumber($cardData['last4'])
                ->setExpMonth($cardData['exp_month'])
                ->setExpYear($cardData['exp_year'])
            ;

        }
        catch(\Stripe_CardError $e) {
            throw new CardDeclinedException($e->getMessage());
        }
    }

    protected function getEntityManager()
    {
        return $this->container
                    ->get('doctrine')
                    ->getManager();
    }

    /**
     * Get the user
     *
     * @return \UVd\UserBundle\Entity\User
     */
    protected function getUser()
    {
        return $this->container
                ->get('security.context')
                ->getToken()
                ->getUser();
    }
} 