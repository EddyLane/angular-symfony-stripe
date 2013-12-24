<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 15/12/2013
 * Time: 20:01
 */

namespace UVd\PaymentBundle\Manager;

class CardManager extends BaseManager
{
    public function findOneByToken($token)
    {
        return $this->getRepository()->findOneByToken($token);
    }
}