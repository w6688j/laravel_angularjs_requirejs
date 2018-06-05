define(['angular', 'angular-async-loader', 'module', 'exports', 'functions'],
    function (angular, asyncLoader, module, exports) {
        let app = angular.module('laravel', ['ui.router', 'ajaxLoading']);
        asyncLoader.configure(app);
        module.exports = app;

        return app;
    });