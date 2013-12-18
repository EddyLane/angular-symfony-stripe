<?php

namespace UVd\PaymentBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;

class PaymentController extends BaseController
{
    /**
     * @RequestParam(name="token", description="Stripe token.")
     * @View(statusCode=201)
     */
    public function postPayAction(ParamFetcher $paramFetcher)
    {
        $manager = $this->get('uvd.payment.payment_manager');

        $payment = $manager->create(array_merge($paramFetcher->all(), [
            'user' => $this->getUser()
        ]));

        $return = $this->get('uvd.payment.stripe_provider')
            ->create($payment)
        ;

        $manager->save($payment, true);

        return $return;
    }
}