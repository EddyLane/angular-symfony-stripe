'use strict';

angular.module('angularStripeTestApp')
    .controller('MainCtrl', function ($scope, $http, stripeFactory) {

        /**
         * handle response errors
         *
         * @param error
         */
        var handleError = function (error) {

                var field;

                if (!error.param || !$scope.values[error.param]) {
                    throw new Error('No error or can\'t find response.param in $scope.values');
                }

                field = $scope.values[error.param];

                $scope.$apply(function() {
                    field.error = error.message;
                    field.code = error.code;
                });
            },

            /**
             * reset all error messages
             */
            resetErrors = function () {
                angular.forEach($scope.values, function (input) {
                    input.error = false;
                });
            },


            /**
             * save response to database
             */
            saveToken = function (token) {

                stripeFactory.pay({
                    token: token
                });

            };

        /**
         * Assign values
         *
         * @type {{number: {}, cvc: {}, exp_month: {}, exp_year: {}}}
         */
        $scope.values = {
            'number': {},
            'cvc': {},
            'exp_month': {},
            'exp_year': {}
        };

        /**
         * Submit the form
         *
         * @param values
         * @returns {boolean}
         */
        $scope.pay = function (values) {

            $scope.submitted = true;

            if ($scope.form.$invalid) {
                return false;
            }

            $scope.submitting = true;

            Stripe.card.createToken({

                number: values.number.value,
                cvc: values.cvc.value,
                exp_month: values.exp_month.value,
                exp_year: values.exp_year.value

            }, function (status, response) {

                $scope.submitting = false;
                resetErrors();
                if (status === 402) {
                    handleError(response.error);
                } else {
                    saveToken(response.id);
                }

            });

            return true;
        };
    });
