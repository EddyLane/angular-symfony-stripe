<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 06/12/2013
 * Time: 17:43
 */

namespace UVd\PaymentBundle\Proxy;

use Stripe;
use Stripe_Card;
use Stripe_Customer;

class StripeProxy implements StripeProxyInterface
{
    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        Stripe::setApiKey($apiKey);
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return Stripe::getApiKey();
    }

    public function createCharge(array $data)
    {
        return Stripe_Charge::create($data);
    }

    public function createCard(array $data)
    {
        return Stripe_Card::create($data);
    }

    public function createCustomer(array $data)
    {
        return Stripe_Customer::create($data);
    }

    public function retrieveCustomer($id)
    {
        return Stripe_Customer::retrieve($id);
    }

} 