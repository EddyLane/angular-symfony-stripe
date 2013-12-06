<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 06/12/2013
 * Time: 17:56
 */
namespace UVd\PaymentBundle\Proxy;

interface StripeProxyInterface
{
    /**
     * @param array $chargeData
     * @return array
     */
    public function createCharge(array $chargeData);

    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey);

    /**
     * @return string
     */
    public function getApiKey();
}