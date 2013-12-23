'use strict';

angular.module('angularStripeTestApp')

    .service('userService', function ($http, $q, USER_ME_URL, LOGIN_URL, LOGOUT_URL) {

        var defer = $q.defer(),

            self = this,

            fns = {

                logout: function() {

                    var self = this;

                    if (!self.authenticated) {
                        throw new Error('Not logged in');
                    }

                    $http.get(LOGOUT_URL)
                        .success(function () {
                            self.authenticated = false;
                            self.username = undefined;
                            self.email = undefined;
                        });

                },

                register: function (username, password) {
                    var defer = $q.defer(),
                        self = this;

                    $http({
                        url: REGISTER_URL,
                        method: 'POST',
                        data: $.param({ _username: username, _password: password }),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                        .success(function (data) {

                            self.authenticated = true;

                            angular.extend(self, data);

                            defer.resolve(true);
                        })
                        .error(function () {
                            defer.resolve();
                        });

                    return defer.promise;
                },

                refresh: function () {
                    $http.get(USER_ME_URL)
                        .success(function (data) {
                            angular.extend(self, data);
                        });
                },

                authenticate: function (username, password) {

                    var defer = $q.defer(),
                        self = this;

                    $http({
                        url: LOGIN_URL,
                        method: 'POST',
                        data: $.param({ _username: username, _password: password }),
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                    .success(function (data) {

                            self.authenticated = true;

                            angular.extend(self, data);

                            defer.resolve(true);
                        })
                        .error(function () {
                            defer.resolve();
                        });

                    return defer.promise;
                }
            };

        $http.get(USER_ME_URL)
            .success(function (data) {
                defer.resolve(angular.extend(angular.extend(data, fns), { authenticated: true }));
            })
            .error(function () {
                defer.resolve(angular.extend(fns, { authenticated: false }));
            });

        return defer.promise;
    });