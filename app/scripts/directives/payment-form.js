'use strict';

angular.module('angularStripeTestApp')
    .directive('paymentForm', function () {
        return {
            restrict: 'E',
            scope: {
                cards: '='
            },
            templateUrl: 'views/partials/payment-form.html',
            controller: function ($scope, stripeFactory, Card) {

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

                    clearForm = function () {
                        angular.forEach($scope.values, function (input, key) {
                            $scope.values[key] = {};
                        })
                    },

                    /**
                     * save response to database
                     */
                        saveToken = function (token, cb) {

                        var card = new Card({ token: token });

                        card.$save(function (cardData) {
                            angular.extend(card, cardData);
                            $scope.cards.push(card);
                            cb();
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
                    'exp_year': {},
                    'expiry': {}
                };

                /**
                 * Submit the form
                 *
                 * @param values
                 * @returns {boolean}
                 */
                $scope.pay = function (values) {

                    var dateValues,
                        month,
                        year;


                    $scope.submitted = true;
                    $scope.success = false;
                    $scope.error = false;

                    if ($scope.form.$invalid) {
                        return false;
                    }

                    dateValues = values.expiry.value.split('/');
                    month = parseInt(dateValues[0], 10);
                    year = parseInt(dateValues[1], 10);

                    $scope.submitting = true;

                    Stripe.card.createToken({

                        number: values.number.value,
                        cvc: values.cvc.value,
                        exp_month: month,
                        exp_year: year

                    }, function (status, response) {

                        resetErrors();
                        if (status === 402) {
                            $scope.submitting = false;
                            handleError(response.error);
                        } else if (status === 200) {
                            saveToken(response.id, function () {
                                $scope.submitting = false;
                                $scope.submitted = false;
                                clearForm();
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
