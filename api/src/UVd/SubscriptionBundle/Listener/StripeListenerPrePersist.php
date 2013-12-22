<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 22/12/2013
 * Time: 21:06
 */

namespace UVd\SubscriptionBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use UVd\SubscriptionBundle\Entity\Subscription;
use Symfony\Component\DependencyInjection\Container;
use UVd\PaymentBundle\Proxy\StripeProxy;

class StripeListenerPrePersist {
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

        if ($entity instanceof Subscription) {
            $this->stripeProxy->createPlan([
                "amount" => $entity->getPrice(),
                "interval" => "month",
                "name" => $entity->getDescription(),
                "currency" => "gbp",
                "id" => $entity->getName()
            ]);
        }
    }
}