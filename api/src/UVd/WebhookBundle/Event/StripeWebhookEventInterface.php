<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 24/12/2013
 * Time: 00:37
 */

namespace Uvd\WebhookBundle\Event;


interface StripeWebhookEventInterface {
    public function getEventName();
    public function getResponse();
}