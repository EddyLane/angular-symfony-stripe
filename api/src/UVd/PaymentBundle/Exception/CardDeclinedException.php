<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 15/12/2013
 * Time: 16:31
 */

namespace UVd\PaymentBundle\Exception;


class CardDeclinedException extends \Exception {

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}