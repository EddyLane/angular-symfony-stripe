<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 24/12/2013
 * Time: 00:34
 */

namespace Uvd\WebhookBundle\Listener;

use UVd\PaymentBundle\Manager\PaymentManager;
use UVd\PaymentBundle\Proxy\StripeProxy;
use UVd\UserBundle\Manager\UserManager;
use Uvd\WebhookBundle\Event\StripeWebhookEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class StripeWebhookListener implements EventSubscriberInterface
{

    protected $logger;

    protected $stripeProxy;

    protected $userManager;

    public function __construct(LoggerInterface $logger, StripeProxy $stripeProxy, PaymentManager $paymentManager, UserManager $userManager)
    {
        $this->logger = $logger;
        $this->stripeProxy = $stripeProxy;
        $this->userManager = $userManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            'uvd_stripe_webhook.generic' => 'onGenericWebhookEvent'
        ];
    }

    public function onGenericWebhookEvent(StripeWebhookEventInterface $event)
    {
        $response = $event->getResponse();

        try {

            $eventData = $this->stripeProxy->retrieveEvent($response['id'])->__toArray(true);
            $id = 'RETRIEVED FROM STRIPE : ' . $eventData['id'];
            $type = 'RETRIEVED FROM STRIPE : ' . $eventData['type'];
            $this->logger->info("Stripe webhook received. ID: {$id}, Type: {$type}");

            switch($eventData['type']) {
                case 'customer.subscription.deleted':
                    $this->logger->info("Stripe SUBSCRIPTION DELETED received. ID: {$id}, Type: {$type}");
                    $this->logger->warning('Deleting the following users subscription: '.$eventData['customer']);
                    $user = $this->userManager->findByStripeId($eventData['customer'])->setSubscription(null);
                    $this->userManager->save($user, true);
                    break;
                default:
                    $this->logger->info("Stripe webhook received. ID: {$id}, Type: {$type}");
            };


        }
        catch(\Stripe_Error $e) {
            $this->logger->info("Stripe TEST WEBHOOK CALL webhook received. ID: {$response['id']}, Type: {$response['type']}");
        }

        return true;

    }
}