'use strict';

angular.module('angularStripeTestApp')
    .directive('cardList', function () {
        return {
            restrict: 'E',
            scope: {
                'cards': '='
            },
            templateUrl: 'views/partials/card-list.html',
            controller: function ($scope, Card) {
                angular.extend($scope, {

                    removeCard: function (card, i) {

                        card.deleting = true;

                        Card['delete']({ id: card.id }, function () {
                            $scope.cards.splice(i, 1);
                        });
                    }

                });



            }
        };
    });
