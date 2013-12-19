'use strict';

angular.module('angularStripeTestApp')

    .factory('Subscription', function ($resource, SUBSCRIPTION_URL) {
        return $resource(SUBSCRIPTION_URL);
    });