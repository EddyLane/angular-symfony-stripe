'use strict';

angular.module('angularStripeTestApp')
    .directive('loginForm', function () {
        return {
            restrict: 'E',
            scope: {
                'user': '=user'
            },
            templateUrl: 'views/partials/login-form.html',
            controller: 'LoginFormCtrl'
        };
    });
