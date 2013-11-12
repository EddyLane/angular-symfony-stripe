'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http) {

        $scope.pay = function(values) {
            $scope.submitting = true;
            Stripe.card.createToken(values, function(status, response) {

                $scope.submitting = false;

                if (response.error) {

                } else {
                    $http.post('http://app.stripe-test.local/app_dev.php/pay', { token: response.id }, function(response) {

                    });
                }
            });
        };
    });
