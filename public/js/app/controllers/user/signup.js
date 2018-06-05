define(['laravel', 'srv/userService'], function (laravel) {
    return laravel
        .controller('signup', [
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
            }]);
});