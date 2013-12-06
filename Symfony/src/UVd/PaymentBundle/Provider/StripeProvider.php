<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 17/11/2013
 * Time: 12:55
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Provider;

use UVd\PaymentBundle\Entity\Payment;
use UVd\PaymentBundle\Proxy\StripeProxy;


class StripeProvider
{

    protected $stripeProxy;

    /**
     * @param StripeProxy $stripeProxy
     * @param $apiKey
     */
    public function __construct(StripeProxy $stripeProxy, $apiKey)
    {
        $this->stripeProxy = $stripeProxy;
        $this->stripeProxy->setApiKey($apiKey);
    }

    /**
     * Create payment
     *
     * @param Payment $payment
     * @return \Stripe_Charge
     * @throws \Exception
     * @throws \Stripe_CardError
     */
    public function create(Payment $payment)
    {
        if(!$payment->getToken()) {
            throw new \ErrorException('Token on payment is not set');
        }

        try {
            $charge = $this
                ->stripeProxy
                ->createCharge([
                    "amount" => 1000,
                    "currency" => "usd",
                    "card" => $payment->getToken(),
                    "description" => "payinguser@example.com"
                ])
            ;
        }
        catch (Stripe_CardError $e) {
            throw $e;
        }

        $payment->setCompleted(true);

        return $charge;
    }

}