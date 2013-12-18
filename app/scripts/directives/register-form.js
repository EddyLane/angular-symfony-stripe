'use strict';

angular.module('angularStripeTestApp')
    .directive('registerForm', function () {
        return {
            restrict: 'E',
            scope: {
                'user': '=user'
            },
            templateUrl: 'views/partials/register-form.html',
            controller: 'RegisterFormCtrl'
        };
    });
