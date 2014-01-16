'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory, user, Card, subscriptions) {

        var selected = user.stripe_profile ? user.stripe_profile.subscription : undefined;

        $scope.subscriptions = subscriptions;

        $scope.selected = angular.copy(selected);

        $scope.subscribe = function (subscription) {
            $scope.selected = subscription;
        };

    });
