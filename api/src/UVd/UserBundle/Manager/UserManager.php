<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 16/11/2013
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\UserBundle\Manager;

use UVd\PaymentBundle\Manager\BaseManager;

class UserManager extends BaseManager
{

    public function findByStripeId($stripeId)
    {
        return $this->getRepository()->findOneByStripeId($stripeId);
    }

}