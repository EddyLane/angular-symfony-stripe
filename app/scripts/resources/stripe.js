'use strict';

angular.module('angularStripeTestApp')

    .factory('stripeFactory', function ($resource, API) {
        return $resource(API + '/pay', {}, {
            pay: { method: 'POST', isArray: false }
        });
    });