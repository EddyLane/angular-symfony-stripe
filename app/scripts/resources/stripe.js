'use strict';

angular.module('angularStripeTestApp')

    .factory('stripeFactory', function ($resource, PAYMENT_URL) {
        return $resource(PAYMENT_URL, {}, {
            pays: { method: 'POST', isArray: false }
        });
    });