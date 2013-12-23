<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 22/12/2013
 * Time: 21:06
 */

namespace UVd\UserBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UVd\PaymentBundle\Exception\CardDeclinedException;
use UVd\SubscriptionBundle\Entity\Subscription;
use Symfony\Component\DependencyInjection\Container;
use UVd\PaymentBundle\Proxy\StripeProxy;
use UVd\UserBundle\Entity\User;

class StripeListenerPreUpdate {
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
     * @throws \UVd\PaymentBundle\Exception\CardDeclinedException
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof User) {

            if(!$entity->getStripeId() || !$entity->getSubscription()) {
                return;
            }

            try {
                $customer = $this
                    ->stripeProxy
                    ->retrieveCustomer($entity->getStripeId())
                ;

                $customer->updateSubscription(["plan" => $entity->getSubscription()->getName(), "prorate" => true]);

            }
            catch(\Stripe_CardError $e) {
                throw new CardDeclinedException($e->getMessage());
            }

        }
    }
}