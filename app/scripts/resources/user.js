'use strict';

angular.module('angularStripeTestApp')

    .factory('userManager', function ($resource) {
        return $resource('user', {}, {
            me: { method: 'GET', isArray: false },
            get: { method: 'GET', isArray: false }
        });
    });