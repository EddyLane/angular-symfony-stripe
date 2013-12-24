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
use UVd\PaymentBundle\Manager\CardManager;
use UVd\UserBundle\Manager\UserManager;
use Uvd\WebhookBundle\Event\StripeWebhookEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class StripeWebhookListener implements EventSubscriberInterface
{

    protected $logger;

    protected $stripeProxy;

    protected $userManager;

    protected $cardManager;

    protected $paymentManager;

    public function __construct(
        LoggerInterface $logger,
        StripeProxy $stripeProxy,
        PaymentManager $paymentManager,
        UserManager $userManager,
        CardManager $cardManager
    )
    {
        $this->logger = $logger;
        $this->stripeProxy = $stripeProxy;
        $this->userManager = $userManager;
        $this->cardManager = $cardManager;
        $this->paymentManager = $paymentManager;
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

            $this->logger->info("Stripe webhook received. ID: {$response['id']}, Type: {$response['type']}");
            $eventData = $this->stripeProxy->retrieveEvent($response['id']);

            switch($eventData['type']) {

                case 'customer.subscription.deleted':

                    $this->logger->info("Stripe SUBSCRIPTION DELETED. Removing subscription for user \"{$eventData->data->object->customer}\": . ID: {$response['id']}, Type: {$response['type']}");
                    $user = $this->userManager->findOneByStripeId($eventData->data->object->customer);

                    if($user) {
                        $user->setSubscription(null)
                             ->setSubscriptionEnd(null)
                             ->setSubscriptionStart(null)
                        ;
                        $this->userManager->save($user, true);
                    }

                    break;

                case 'invoice.payment_succeeded':

                    $this->logger->info("Stripe INVOICE CREATED. for user \"{$eventData->data->object->customer}\": . ID: {$response['id']}, Type: {$response['type']}");
                    $user = $this->userManager->findOneByStripeId($eventData->data->object->customer);

                    $cardData = $this->stripeProxy->retrieveCharge($eventData->data->object->charge);
                    $card = $this->cardManager->findOneByToken($cardData->card->id);

                    $payment = $this->paymentManager->create();

                    $payment
                            ->setSubscription($user->getSubscription())
                            ->setCard($card)
                            ->setToken($eventData->data->object->id)
                            ->setUser($user)
                            ->setCompleted(true)
                    ;


                    $this->paymentManager->save($payment, true);

                    break;

                default:
                    $this->logger->info("Stripe webhook received. ID: {$eventData->id}, Type: {$eventData->type}");
                    break;
            };


        }
        catch(\Stripe_Error $e) {
            $this->logger->info("Stripe TEST WEBHOOK CALL webhook received. ID: {$response['id']}, Type: {$response['type']}");
        }

        return true;

    }
}