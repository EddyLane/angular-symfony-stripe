'use strict';

angular.module('angularStripeTestApp')
    .directive('cardDisplay', function () {
        return {
            restrict: 'E',
            scope: {
                'card': '='
            },
            templateUrl: 'views/partials/card-display.html'
        };
    });
