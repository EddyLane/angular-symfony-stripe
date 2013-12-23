'use strict';

angular.module('angularStripeTestApp')
    .directive('subscriptionChangeForm', function () {
        return {
            restrict: 'E',
            scope: {
                card: '=',
                subscription: '=',
                user: '='
            },
            transclude: true,
            templateUrl: 'views/partials/subscription-change-form.html',
            controller: function ($scope) {

                $scope.submit = function () {
                    $scope.submitting = true;

                    $scope.subscription.$subscribes({
                        id: $scope.card.id
                    }, function () {
                        $scope.submitting = false;
                        $scope.user.subscription = $scope.subscription;
                    });
                };

            }
        };
    });