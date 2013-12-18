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

class StripeListenerPreRemove
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
    public function __construct(Container $container,StripeProxy $stripeProxy)
    {
        $this->container = $container;
        $this->stripeProxy = $stripeProxy;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Card) {
            $this->removeCard($entity);
        }
    }

    /**
     * @param Card $card
     * @throws \UVd\PaymentBundle\Exception\CardDeclinedException
     */
    private function removeCard(Card $card)
    {
        try {

            $customer = $this
                ->stripeProxy
                ->retrieveCustomer($this->getUser()->getStripeId())
            ;

            (array) $cardData = $customer
                ->cards
                ->retrieve($card->getToken())
                ->delete()
            ;

        }
        catch(\Stripe_CardError $e) {
            throw new CardDeclinedException($e->getMessage());
        }
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