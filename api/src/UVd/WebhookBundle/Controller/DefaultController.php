<?php

namespace Uvd\WebhookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Uvd\WebhookBundle\Event\StripeWebhookEvent;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/webhook")
     */
    public function indexAction(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $event = is_array($content) && isset($content['type']) ? $content['type'] : 'unknown';

        $this->container->get('event_dispatcher')->dispatch(
            'mrp_stripe_webhook.generic',
            new StripeWebhookEvent($event, $content)
        );

        $this->container->get('event_dispatcher')->dispatch(
            'mrp_stripe_webhook.'. $event,
            new StripeWebhookEvent($event, $content)
        );

        return new JsonResponse([]);
    }
}
