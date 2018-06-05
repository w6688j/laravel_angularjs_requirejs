define(['laravel', 'config'], function (laravel, config) {
    laravel.run(['$state', '$stateParams', '$rootScope',
        function ($state, $stateParams, $rootScope) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;
        }]);

    laravel.config(['$stateProvider', '$urlRouterProvider', '$locationProvider',
        function ($stateProvider, $urlRouterProvider, $locationProvider) {
            $urlRouterProvider.otherwise('/laravel/home');
            $stateProvider
                .state('home', {
                    url: '/laravel/home',
                    templateUrl: config.tpl('home'),
                    controllerUrl: 'ctrl/index',
                    controller: 'index'
                })
                .state('signup', {
                    url: '/laravel/signup',
                    templateUrl: config.tpl('/user/signup'),
                    controllerUrl: 'ctrl/user/signup',
                    controller: 'signup'
                })
                .state('login', {
                    url: '/laravel/login',
                    templateUrl: config.tpl('/user/login'),
                    controllerUrl: 'ctrl/user/login',
                    controller: 'login'
                });

            $locationProvider.html5Mode(true).hashPrefix('!');
        }]);
});