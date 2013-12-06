<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 06/12/2013
 * Time: 17:43
 */

namespace UVd\PaymentBundle\Proxy;

use Stripe;
use Stripe_Charge;

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

    /**
     * @param array $chargeData
     * @return array
     */
    public function createCharge(array $chargeData)
    {
        return Stripe_Charge::create($chargeData);
    }

} 