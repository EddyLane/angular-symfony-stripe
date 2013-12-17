'use strict';

angular.module('angularStripeTestApp')

    .factory('stripeFactory', function ($resource, PAYMENT_URL) {
        return $resource(PAYMENT_URL, {}, {
            pays: { method: 'POST', isArray: false }
        });
    })
    .factory('Card', function ($resource, CARD_URL) {
        return $resource(CARD_URL, { id: '@id' });
    })