<?php

namespace UVd\PaymentBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class PaymentController extends BaseController
{
    /**
     * @RequestParam(name="token", description="Stripe token.")
     */
    public function postPayAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('uvd.payment.payment_manager');

        $stripe = $this->get('uvd.payment.stripe_provider');

        $payment = $manager->create(array_merge($paramFetcher->all(), [
            'user' => $this->user
        ]));

        $manager->save($payment);

        $charge = $stripe->create($payment);

        return $charge ? $payment : ['error' => 'fiuck'];
    }
}
