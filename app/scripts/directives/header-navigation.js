'use strict';

angular.module('angularStripeTestApp')
    .directive('headerNavigation', function () {
        return {
            restrict: 'E',
            scope: {},
            templateUrl: 'views/partials/header-navigation.html',
            controller: function ($scope, $location) {

                var setActive = function () {
                    var path = $location.path();
                    angular.forEach($scope.items, function (item) {
                        item.active = !!(item.link === path);
                    });
                };

                $scope.items = [
                    { name: 'Manage cards', link: '/cards', active: false },
                    { name: 'Subscriptions', link: '/subscriptions', active: false },
                    { name: 'Payments', link: '/payments', active: false }
                ];

                $scope.$on('$locationChangeSuccess', setActive);
                setActive();

            }
        };
    });
