<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/12/2013
 * Time: 22:09
 */

namespace UVd\SubscriptionBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use UVd\SubscriptionBundle\Entity\Subscription;

class SubscriptionController extends FOSRestController
{
    public function getSubscriptionsAction()
    {
        $manager = $this->container->get('uvd.subscription.subscription_manager');
        return $manager->findAll();
    }

    /**
     * @ParamConverter("subscription", converter="fos_rest.request_body")
     * @View(statusCode=201)
     */
    public function putSubscriptionSubscribesAction(Subscription $subscription)
    {
        $subscription = $manager = $this->container->get('uvd.subscription.subscription_manager')->find($subscription->getId());
        $user = $this->getUser();
        $user->setSubscription($subscription);
        $userManager = $this->get('uvd.user.user_manager');
        $userManager->save($user, true);
    }

} 