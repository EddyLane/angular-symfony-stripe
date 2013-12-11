'use strict';

angular.module('angularStripeTestApp')
    .controller('LoginFormCtrl', function ($scope) {

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

    });
