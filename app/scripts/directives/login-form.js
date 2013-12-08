'use strict';

angular.module('angularStripeTestApp')
    .directive('loginForm', function () {
        return {
            restrict: 'E',
            scope: {
                'user': '=user'
            },
            templateUrl: 'views/partials/login-form.html',
            controller: function ($scope) {

                $scope.submit = function () {

                    $scope.submitted = true;
                    $scope.error = false;

                    if ($scope.form.$invalid) {
                        return false;
                    }

                    $scope.submitting = true;

                    $scope.user.authenticate($scope.username, $scope.password).then(function (success) {
                        $scope.submitting = false;

                        if (!success) {
                            $scope.error = true;
                        }

                    });

                    return true;
                };

            }
        };
    });
