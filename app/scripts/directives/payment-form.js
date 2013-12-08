'use strict';

angular.module('angularStripeTestApp')
    .directive('paymentForm', function () {
        return {
            restrict: 'E',
            scope: {},
            templateUrl: 'views/partials/payment-form.html',
            controller: function ($scope, stripeFactory) {

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

                        $scope.$apply(function () {
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
                        saveToken = function (token, cb) {

                        stripeFactory.pays({
                            token: token
                        }, function () {
                            $scope.success = true;
                            cb();
                        }, function () {
                            $scope.error = true;
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
                    $scope.success = false;
                    $scope.error = false;

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

                        resetErrors();
                        if (status === 402) {
                            $scope.submitting = false;
                            handleError(response.error);
                        } else if (status === 200) {
                            saveToken(response.id, function () {
                                $scope.submitting = false;
                            });
                        } else {
                            $scope.submitting = false;
                        }

                    });

                    return true;
                };
            }
        };
    });
