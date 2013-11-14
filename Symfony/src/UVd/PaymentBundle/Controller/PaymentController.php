<?php

namespace UVd\PaymentBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;


class PaymentController extends FOSRestController
{

    /**
     * @RequestParam(name="token", description="Stripe token.")
     */
    public function postPayAction(ParamFetcher $paramFetcher)
    {
        return $this->handleView(
            ['token' => $paramFetcher->get('token')]
        );
    }
}
