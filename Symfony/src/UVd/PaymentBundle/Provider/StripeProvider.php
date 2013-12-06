<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 17/11/2013
 * Time: 12:55
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Provider;
require_once(dirname(__FILE__) . "/../../../../vendor/stripe/stripe-php/lib/Stripe.php");

use UVd\PaymentBundle\Entity\Payment;
use Stripe;
use Stripe_Charge;
use Stripe_CardError;

class StripeProvider
{

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        Stripe::setApiKey($apiKey);
    }

    /**
     * Create payment
     *
     * @param Payment $payment
     * @return array
     * @throws \Exception
     * @throws \Stripe_CardError
     */
    public function create(Payment $payment)
    {
        try {
            $charge = Stripe_Charge::create([
                    "amount" => 1000, // amount in cents, again
                    "currency" => "usd",
                    "card" => $payment->getToken(),
                    "description" => "payinguser@example.com"
            ]);
        }
        catch (Stripe_CardError $e) {
            throw $e;
        }

        $payment->setCompleted(true);

        return $charge;
    }

}