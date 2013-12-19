'use strict';

angular.module('angularStripeTestApp')
    .directive('subscriptionListDisplay', function () {
        return {
            restrict: 'E',
            scope: {
                'subscription': '='
            },
            templateUrl: 'views/partials/subscription-list-display.html',
        };
    });
