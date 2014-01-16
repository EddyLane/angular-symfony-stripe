'use strict';

angular.module('angularStripeTestApp')

    .service('subscriptionService', function (Subscription, $q) {
        var defer = $q.defer();
        Subscription.query(function (subscriptions) {
            defer.resolve(subscriptions);
        });
        return {
            subscriptions: defer.promise
        };
    });