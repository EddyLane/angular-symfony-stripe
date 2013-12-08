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
use UVd\UserBundle\Entity\User;
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


    public function createCustomer(User $user, Payment $payment = null)
    {
        if($user->getStripeId()) {
            throw new \ErrorException('User has a stripe ID already');
        }

        $parameters = [
            'description' => (String) $user
        ];

        if(!is_null($payment)) {
            $parameters['card'] = $payment->getToken();
        }

        $customer = $this->stripeProxy
            ->createCustomer($parameters)
        ;

        $user
            ->setStripeId($customer->__get('id'))
        ;

        return $user;
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

        if(!$payment->getUser()->getStripeId()) {
            return $this->createCustomer($payment->getUser(), $payment);
        }

        $this
            ->stripeProxy
            ->createCharge([
                "amount" => 1000,
                "currency" => "usd",
                "card" => $payment->getToken(),
                "description" => "payinguser@example.com"
            ])
        ;

        $payment->setCompleted(true);

        return $payment;
    }

}