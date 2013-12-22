'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory, user, Card, Subscription) {

        Card.query(function (cards) {
            $scope.cards = cards;
        });

        Subscription.query(function (subscriptions) {
            $scope.subscriptions = subscriptions;
        });

    });
