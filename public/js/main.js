requirejs.config({
    //By default load any module IDs from js/lib
    baseUrl: '/js/',
    /*urlArgs: function (id, url) {
        var args = 'v=201805241516';
        if (url.indexOf('libs') !== -1) {
            args = 'v=1';
        }

        return (url.indexOf('?') === -1 ? '?' : '&') + args;
    },*/

    //except, if the module ID starts with "app",
    //load it from the js/app directory. paths
    //config is relative to the baseUrl, and
    //never includes a ".js" extension since
    //the paths config could be for a directory.
    paths: {
        "jquery": '//apps.bdimg.com/libs/jquery/2.1.4/jquery.min',
        "angular": '//apps.bdimg.com/libs/angular.js/1.4.6/angular.min',
        "angular-ui-router": "//apps.bdimg.com/libs/angular-ui-router/0.2.15/angular-ui-router.min",
        "laravel": "app/app",
        "angular-async-loader": "libs/angular-async-loader.min",
        "ctrl": 'app/controllers',
        "srv": 'app/services',
        "dire": 'app/directives',
        "config": 'app/config',
        "functions": 'app/functions'
    },
    shim: {
        "functions": ["jquery"],
        'angular': {
            exports: 'angular'
        },
        'angular-ui-router': {
            deps: ["angular"]
        },
        'config': {
            deps: ['angular'],
            exports: 'config'
        }
    }
});

// Start the main app logic.
requirejs(['jquery', 'angular', 'laravel', 'ctrl/loadingInterceptor', 'angular-ui-router', 'app/routers', 'app/filter'],
    function ($, angular) {
        $(function () {
            angular.bootstrap(document, ['laravel'])
        });
    });