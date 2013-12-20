'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory, user, Card, Subscription) {
        $scope.cards = Card.query();

        $scope.subscriptions = Subscription.query(function (subscriptions) {
            $scope.currentSubscription = subscriptions[0];
            $scope.currentSelection = subscriptions[0];
        });
    });
