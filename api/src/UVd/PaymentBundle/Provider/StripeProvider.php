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

        if(!$payment->isValid()) {
            throw new \ErrorException('Payment is not valid');
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
        catch (\Stripe_InvalidRequestError $e) {
            throw $e;
            throw new \Exception('Invalid request error: ' . $e->getMessage());
        }
        catch (Stripe_CardError $e) {
            throw new \Exception('Card error');
        }

        $payment->setCompleted(true);

        return $charge;
    }

}