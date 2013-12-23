'use strict';

angular.module('angularStripeTestApp')

    .factory('Subscription', function ($resource, SUBSCRIPTION_URL) {
        return $resource(SUBSCRIPTION_URL, { subscriptionId: '@id' }, {
            subscribes: { method: 'PUT', params: { subscriptionId: '@id' }, url: SUBSCRIPTION_URL + '/subscribes' }
        });
    });