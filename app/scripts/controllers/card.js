'use strict';

angular.module('angularStripeTestApp')
    .controller('CardCtrl', function ($scope, user) {

        if (user.stripe_profile) {
            angular.forEach(user.stripe_profile.cards, function (card) {
                if (card.id === user.stripe_profile.default_card_id) {
                    $scope.default = card;
                    return;
                }
            });
        }

    });
