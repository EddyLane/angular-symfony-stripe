<?php

namespace UVd\PaymentBundle\Controller;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CardController extends BaseController
{

    /**
     * @param $id
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function deleteCardAction($id)
    {
        $cardManager = $this->container->get('uvd.payment.card_manager');
        $card = $cardManager->find($id);

        if(!$card || !$card->belongsTo($this->getUser())) {
            throw new HttpException(403, 'Forbidden');
        }

        $cardManager->remove($card, true);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCardsAction()
    {
        return $this->getUser()->getCards();
    }

    /**
     * @RequestParam(name="token", description="Stripe token.")
     * @View(statusCode=201)
     */
    public function postCardAction(ParamFetcher $paramFetcher)
    {
        $cardManager = $this->container->get('uvd.payment.card_manager');

        $card = $cardManager->create($paramFetcher->get('token'));

        $cardManager->save($card, true);

        return $card;
    }

}