'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory, user, Card, Subscription) {

        Subscription.query(function (subscriptions) {
            $scope.subscriptions = subscriptions;
        });

        $scope.selected = angular.copy(user.subscription);

        $scope.subscribe = function (subscription) {
            $scope.selected = subscription;
        };

    });
