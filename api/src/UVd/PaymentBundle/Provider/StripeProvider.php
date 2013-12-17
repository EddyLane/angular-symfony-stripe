<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edwardlane
 * Date: 17/11/2013
 * Time: 12:55
 * To change this template use File | Settings | File Templates.
 */

namespace UVd\PaymentBundle\Provider;

use UVd\PaymentBundle\Entity\Payment;
use UVd\PaymentBundle\Exception\CardDeclinedException;
use UVd\PaymentBundle\Manager\CardManager;
use UVd\UserBundle\Entity\User;
use UVd\PaymentBundle\Proxy\StripeProxy;
use UVd\PaymentBundle\Entity\Card;

class StripeProvider
{

    protected $stripeProxy;
    protected $cardManager;

    /**
     * @param StripeProxy $stripeProxy
     * @param CardManager $cardManager
     */
    public function __construct(StripeProxy $stripeProxy, CardManager $cardManager)
    {
        $this->stripeProxy = $stripeProxy;
        $this->cardManager = $cardManager;
    }

    public function createCard(User $user, array $parameters)
    {
        if(!$user->getStripeId()) {
            throw new \ErrorException('User must have a stripe ID already');
        }

        try {
            $customer = $this
                ->stripeProxy
                ->retrieveCustomer($user->getStripeId())
            ;

            $cardData = $customer
                ->cards
                ->create([ "card" => $parameters['token'] ])
            ;

        }
        catch(\Stripe_CardError $e) {
            throw new CardDeclinedException($e->getMessage());
        }

        $card = $this->cardManager->create();

        $card
            ->setUser($user)
            ->setToken($cardData['token'])
            ->setCardType(Card::mapCardType($cardData['type']))
            ->setNumber($cardData['last4'])
            ->setExpMonth($cardData['exp_month'])
            ->setExpYear($cardData['exp_year'])
        ;

        $this->cardManager->save($card, true);

        return $card;
    }

    /**
     * @param User $user
     * @param Payment $payment
     * @return User
     * @throws \ErrorException
     * @throws \UVd\PaymentBundle\Exception\CardDeclinedException
     */
    public function createCustomer(User $user, Payment $payment = null)
    {
        if($user->getStripeId()) {
            throw new \ErrorException('User has a stripe ID already');
        }

        $parameters = [
            'description' => (String) $user
        ];

        if(!is_null($payment)) {
            $parameters['card'] = $payment->getToken();
        }

        try {
            (array) $customer = $this->stripeProxy
                ->createCustomer($parameters)
            ;
        }
        catch(\Stripe_CardError $e) {
            throw new CardDeclinedException($e->getMessage());
        }

        $user->setStripeId($customer['id']);

        $cardData = $this->getCardFromCustomerData($customer);

        $card = $this->cardManager->create();
        $card
            ->setUser($user)
            ->setCardType(Card::mapCardType($cardData['type']))
            ->setNumber($cardData['last4'])
            ->setExpMonth($cardData['exp_month'])
            ->setExpYear($cardData['exp_year'])
        ;

        $this->cardManager->save($card, true);

        return $user;
    }

    private function getCardFromCustomerData($data)
    {
        $cards = $data['cards'];
        $card = $cards['data'][0];
        return $card;
    }

    /**
     * Create payment
     *
     * @param Payment $payment
     * @return \Stripe_Charge
     * @throws \Exception
     * @throws \Stripe_CardError
     */
    public function create(Payment $payment)
    {
        if(!$payment->isValid()) {
            throw new \ErrorException('Payment is not valid');
        }

        if(!$payment->getUser()->getStripeId()) {
            return $this->createCustomer($payment->getUser(), $payment);
        }

        try {
            $this
                ->stripeProxy
                ->createCharge([
                    "amount" => 1000,
                    "currency" => "usd",
                    "customer" => $payment->getUser()->getStripeId(),
                ])
            ;
        }
        catch(\Stripe_CardError $e) {
            throw new CardDeclinedException($e->getMessage());
        }

        $payment->setCompleted(true);

        return $payment;
    }

}