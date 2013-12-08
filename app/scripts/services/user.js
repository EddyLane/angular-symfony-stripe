'use strict';

angular.module('angularStripeTestApp')

    .service('userService', function ($http, $q, USER_ME_URL) {

        var defer = $q.defer();

        $http.get(USER_ME_URL).success(function (data) {
            defer.resolve(data);
        });

        return defer.promise;
    });