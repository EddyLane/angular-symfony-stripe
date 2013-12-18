'use strict';

angular.module('angularStripeTestApp', [

        'ngCookies',
        'ngResource',
        'ngSanitize',
        'ngRoute',

        'chieffancypants.loadingBar',
        'angularPayments'
    ])

    .config( function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $httpProvider.defaults.withCredentials = true;
    })


    .config(function ($routeProvider, $httpProvider, STRIPE_KEY) {
        $routeProvider
            .when('/', {
                templateUrl: 'views/main.html',
                controller: 'MainCtrl',
                resolve: {
                    user: ['userService', function (userService) {
                        return userService;
                    }]
                }
            })
            .otherwise({
                redirectTo: '/'
            });
        Stripe.setPublishableKey(STRIPE_KEY);
    })

    .run(function ($rootScope, userService) {

        userService.then(function (user) {
            $rootScope.user = user;
        });

    });
