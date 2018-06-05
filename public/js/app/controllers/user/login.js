define(['laravel', 'srv/userService'], function (laravel) {
    return laravel
        .controller('login', [
            '$scope',
            'UserService',
            function ($scope, UserService) {
                tip('Welcome to login~');
            }
        ]);
});