<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/12/2013
 * Time: 22:09
 */

namespace UVd\SubscriptionBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class SubscriptionController extends FOSRestController
{
    public function getSubscriptionsAction()
    {
        $manager = $this->container->get('uvd.payment.payment_manager');
        return $manager->findAll();
    }
} 