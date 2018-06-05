;(function () {
    'use strict';
    angular.module('laravel', ['ui.router'])
        .config(['$interpolateProvider',
            '$locationProvider',
            '$stateProvider',
            '$urlRouterProvider',
            function ($interpolateProvider,
                      $locationProvider,
                      $stateProvider,
                      $urlRouterProvider) {
                $interpolateProvider.startSymbol('[:');
                $interpolateProvider.endSymbol(':]');
                $urlRouterProvider.otherwise('/laravel/home');
                $stateProvider
                    .state('home', {
                        url: '/laravel/home',
                        templateUrl: tpl('home')
                    })
                    .state('signup', {
                        url: '/laravel/signup',
                        templateUrl: tpl('signup')
                    })
                    .state('login', {
                        url: '/laravel/login',
                        templateUrl: tpl('login')
                    });
                $locationProvider.html5Mode(true);
            }])

        .service('UserService', [
            '$state',
            '$http',
            function ($state, $http) {
                var me = this;
                me.signup_data = {};
                me.signup = function () {
                    $http.post('/api/user/signup', me.signup_data)
                        .then(function (r) {
                            if (r.data.status === 0) {
                                me.signup_data = {};
                                $state.go('login');
                            }
                            console.log('r', r);
                        }, function (e) {
                            console.log('e', e);
                        });
                };
                me.username_exists = function () {
                    if (me.signup_data.username) {
                        $http.post('/api/user/exist', {username: me.signup_data.username})
                            .then(function (r) {
                                me.signup_username_exist = (r.data.data.count > 0);
                            }, function (e) {
                                console.log('e', e);
                            });
                    }
                };
            }])

        .controller('SignupController', [
            '$scope',
            'UserService',
            function ($scope, UserService) {
                $scope.User = UserService;
                $scope.$watch(function () {
                    return UserService.signup_data;
                }, function (newVal, oldVal) {
                    if (newVal.username !== oldVal.username)
                        return UserService.username_exists();
                }, true)
            }
        ]);
})();