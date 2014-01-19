'use strict';

angular.module('angularStripeTestApp')
    .directive('cardList', function () {
        return {
            restrict: 'E',
            scope: {
                'cards': '=',
                'user': '='
            },
            templateUrl: 'views/partials/card-list.html',
            controller: function ($scope, Card) {

                angular.extend($scope, {

                    removeCard: function (card, i) {
                        card.deleting = true;
                        Card.remove({
                            username_canonical: $scope.user.username_canonical,
                            id: card.id
                        }, function () {
                            $scope.user.stripe_profile.cards.splice(i, 1);
                        });
                    },

                    defaultCard: function (card, i) {

                        var cards = $scope.user.stripe_profile.cards,
                            i = 0,
                            l = cards.length;

                        for (; i < l; i++) {
                            cards[i].default = false;
                        }
                        card.default = true;

                        Card.update({
                            username_canonical: $scope.user.username_canonical,
                            id: card.id
                        }, card, function () {

                        });
                    }

                });
            }
        };
    });
