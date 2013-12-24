<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 22/12/2013
 * Time: 21:06
 */

namespace UVd\UserBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use UVd\PaymentBundle\Exception\CardDeclinedException;
use UVd\PaymentBundle\Manager\PaymentManager;
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
     * @var \UVd\PaymentBundle\Manager\PaymentManager
     */
    protected $paymentManager;

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
     * @param PreUpdateEventArgs $eventArgs
     * @throws \UVd\PaymentBundle\Exception\CardDeclinedException]
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof User) {

            if(!$entity->getStripeId() || !$entity->getSubscription() || !$eventArgs->hasChangedField('subscription')) {
                return;
            }

            try {
                $customer = $this
                    ->stripeProxy
                    ->retrieveCustomer($entity->getStripeId())
                ;

                $subscriptionData = $customer->updateSubscription(["plan" => $entity->getSubscription()->getName(), "prorate" => true]);

                $entity->setSubscriptionStart(new \DateTime('@' . $subscriptionData['current_period_start']));
                $entity->setSubscriptionEnd(new \DateTime('@' . $subscriptionData['current_period_end']));

            }
            catch(\Stripe_CardError $e) {
                throw new CardDeclinedException($e->getMessage());
            }

        }
    }
}