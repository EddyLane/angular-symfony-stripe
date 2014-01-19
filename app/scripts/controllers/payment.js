'use strict';

angular.module('angularStripeTestApp')
    .controller('PaymentCtrl', function ($scope, payments) {
        $scope.payments = payments;
    });
