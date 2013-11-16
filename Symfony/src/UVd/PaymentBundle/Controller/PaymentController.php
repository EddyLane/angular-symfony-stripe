<?php

namespace UVd\PaymentBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentController extends FOSRestController
{

    /**
     * Current user.
     *
     * @var \UVd\PaymentBundle\Entity\User
     */
    private $user;

    /**
     * @param Request $request
     * @param SecurityContextInterface $security_context
     * @throws HttpException
     */
    public function initialize(Request $request, SecurityContextInterface $security_context)
    {
        $this->user = $security_context->getToken()->getUser();
        if(!$security_context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new HttpException(403, 'User not logged in');
        }
    }

    /**
     * @RequestParam(name="token", description="Stripe token.")
     */
    public function postPayAction(ParamFetcher $paramFetcher)
    {
        $paymentManager = $this->get('uvd.payment.payment_manager');
        $userManager = $this->get('uvd.payment.user_manager');

        $payment = $paymentManager->create($paramFetcher->all());
        $this->user->addPayment($payment);

        $userManager->save($this->user);

        return $payment;
    }
}
