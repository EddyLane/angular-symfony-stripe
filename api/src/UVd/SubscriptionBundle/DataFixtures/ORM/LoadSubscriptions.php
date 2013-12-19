<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 19/12/2013
 * Time: 21:49
 */

namespace UVd\SubscriptionBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

class LoadSubscriptions extends Loader
{

    protected $fixtures = [
        'UVd/SubscriptionBundle/DataFixtures/Subscription.yml'
    ];


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadFixtures($this->fixtures, $manager);
    }

}