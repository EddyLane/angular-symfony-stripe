'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory, user, Card) {
        $scope.cards = Card.query();
    });
