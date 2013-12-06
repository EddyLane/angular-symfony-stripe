'use strict';

angular.module('angularStripeTestApp', [
        'ngCookies',
        'ngResource',
        'ngSanitize',
        'ngRoute'
    ])

    .config( function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $httpProvider.defaults.withCredentials = true;
    })


    .config(function ($routeProvider, $httpProvider) {

        $routeProvider
            .when('/', {
                templateUrl: 'views/main.html',
                controller: 'MainCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });


        Stripe.setPublishableKey('pk_test_xf2bcw46zdJHzYC8sgwRfASh');
    });
