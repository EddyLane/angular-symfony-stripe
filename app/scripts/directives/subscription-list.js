'use strict';

angular.module('angularStripeTestApp')
    .directive('subscriptionList', function () {
        return {
            restrict: 'E',
            scope: {
                'subscriptions': '=',
                'currentSubscription': '=current'
            },
            templateUrl: 'views/partials/subscription-list.html',
            controller: function ($scope) {
                console.log($scope);
            }
        };
    });
