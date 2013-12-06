<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 17/11/2013
 * Time: 12:08
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BaseController extends FOSRestController {

    /**
     * @param Request $request
     * @param SecurityContextInterface $securityContext
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function initialize(Request $request, SecurityContextInterface $securityContext)
    {
        if(!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new HttpException(403, 'User not logged in');
        }
    }

}