'use strict';

angular.module('angularStripeTestApp')
    .directive('cardList', function () {
        return {
            restrict: 'E',
            scope: {
                'cards': '='
            },
            templateUrl: 'views/partials/card-list.html'
        };
    });
