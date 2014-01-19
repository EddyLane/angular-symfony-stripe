'use strict';

angular.module('angularStripeTestApp')

    .service('paymentService', function (paymentManager, userService, $q) {
        var defer = $q.defer();

        userService.then(function (user) {

            paymentManager.query({
                username_canonical: user.username_canonical
            }, defer.resolve);

        });

        return {
            payments: defer.promise
        };
    });