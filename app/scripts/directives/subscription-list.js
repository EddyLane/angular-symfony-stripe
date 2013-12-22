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

                angular.extend($scope, {
                    setCurrent: function (subscription) {
                        $scope.currentSelection = subscription;
                    }
                });

                $scope.currentSelection = angular.copy($scope.currentSubscription);

            }
        };
    });