'use strict';

angular.module('angularStripeTestApp')
    .directive('subscriptionList', function () {
        return {
            restrict: 'E',
            scope: {
                'subscriptions': '=',
                'currentSubscription': '=current',
                'currentSelection': '=currentSelection'
            },
            templateUrl: 'views/partials/subscription-list.html',
            controller: function ($scope) {
                angular.extend($scope, {

                    setCurrent: function (subscription) {
                        $scope.currentSelection = subscription;
                    }

                });
            }
        };
    });