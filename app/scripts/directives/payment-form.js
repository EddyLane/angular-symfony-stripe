'use strict';

angular.module('angularStripeTestApp')
    .directive('paymentForm', function () {
        return {
            restrict: 'E',
            templateUrl: 'views/partials/payment-form.html',
            controller: function ($scope, stripeFactory, Card, userManager) {

                /**
                 * Handle response errors
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
                     * Reset all error messages
                     */
                    resetErrors = function () {
                        angular.forEach($scope.values, function (input) {
                            input.error = false;
                        });
                    },

                    /**
                     * Clear the form
                     */
                    clearForm = function () {
                        angular.forEach($scope.values, function (input, key) {
                            $scope.values[key] = {};
                        })
                    },

                    /**
                     * Save response to database
                     */
                    saveToken = function (token, cb) {

                        var card, i, cards, l;

                        if (!$scope.user.stripe_profile) {
                            $scope.user.stripe_profile = {
                                cards: []
                            };
                        }

                        card = new Card({ token: token });
                        i = 0;
                        cards = $scope.user.stripe_profile.cards;
                        l = cards.length;

                        card.$save({ username: $scope.user.username }, function (card) {

                            for (; i < l; i++) {
                                cards[i].default = false;
                            }

                            $scope.user.stripe_profile.cards.unshift(card);
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
