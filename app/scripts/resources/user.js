'use strict';

angular.module('angularStripeTestApp')

    .factory('userManager', function ($resource, USER_URL) {
        return $resource(USER_URL, { username: '@username' }, {
            subscribe: { method: 'POST', url: USER_URL + '/subscriptions' }
        });
    });