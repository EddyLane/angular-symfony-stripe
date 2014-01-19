'use strict';

angular.module('angularStripeTestApp')

    .factory('userManager', function ($resource, USER_URL) {
        return $resource(USER_URL, { username_canonical: '@username_canonical' }, {
            subscribe: { method: 'POST', url: USER_URL + '/subscriptions' }
        });
    })

    .factory('paymentManager', function ($resource, USER_URL) {
        return $resource(USER_URL + '/payments', { username_canonical: '@username_canonical' }, {
        });
    });