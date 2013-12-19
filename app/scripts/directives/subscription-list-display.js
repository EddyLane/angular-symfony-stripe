'use strict';

angular.module('angularStripeTestApp')
    .directive('subscriptionListDisplay', function () {
        return {
            restrict: 'E',
            templateUrl: 'views/partials/subscription-list-display.html'
        };
    });
