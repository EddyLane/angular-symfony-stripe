'use strict';

angular.module('angularStripeTestApp')
    .filter('slugify', function () {
        return function (input) {
            return input.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
        };
    })