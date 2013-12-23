<?php

namespace UVd\UserBundle\Controller;

use UVd\PaymentBundle\Controller\BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends BaseController
{

    /**
     * Get a specific user by ID
     *
     * @param $id
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getUserAction($id)
    {
        if((int) $id !== $this->getUser()->getId()) {
            throw new HttpException(403, 'You are not this user');
        }

        $user = $this->get('uvd.payment.user_manager')->find($id);

        return $user;
    }

    public function getUserInvoicesAction($id)
    {

    }

    /**
     * Get currently authenticated user
     *
     * @return mixed
     */
    public function getMeAction()
    {
        $user = $this->getUser();

        return $user;
    }

}
