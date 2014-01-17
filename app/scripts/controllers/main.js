'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory, user, Card, subscriptions, userManager) {

        var selected = user.stripe_profile ? user.stripe_profile.subscription : undefined;

        $scope.subscriptions = subscriptions;

        $scope.selected = angular.copy(selected);

        $scope.subscribe = function (subscription) {

            userManager.subscribe({
                username: $scope.user.username
            }, {
                subscription: subscription.name
            });
        };

    });
