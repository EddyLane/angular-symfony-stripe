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
                            username: $scope.user.username,
                            id: card.id
                        }, function () {
                            $scope.user.stripe_profile.cards.splice(i, 1);
                        });
                    },

                    defaultCard: function (card, i) {
                        card.default = true;
                        Card.update({
                            username: $scope.user.username,
                            id: card.id
                        }, card);
                    }

                });
            }
        };
    });
