<?php
/**
 * Created by PhpStorm.
 * User: edwardlane
 * Date: 11/12/2013
 * Time: 21:51
 */

namespace Acceptance\Context\Web;

use Behat\MinkExtension\Context\RawMinkContext;

class WebContext extends RawMinkContext
{
    /**
     * @Given /^I generate a stripe token$/
     */
    public function iGenerateAStripeToken()
    {

        // Get cURL resource
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.stripe.com/v1/tokens?card[number]=4242424242424242&card[cvc]=123&card[exp_month]=12&card[exp_year]=2013&key=pk_test_xf2bcw46zdJHzYC8sgwRfASh&_method=POST',
            CURLOPT_USERAGENT => 'Stripe CURL'
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
// Close request to clear up some resources
        curl_close($curl);


        $stripeResponse = json_decode($resp);

        $this->getMainContext()->stripeToken = $stripeResponse['id'];

    }


} 