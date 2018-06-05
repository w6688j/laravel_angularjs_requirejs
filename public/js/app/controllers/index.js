define(['laravel'], function (laravel) {
    return laravel
        .controller('index', [function () {
            tip('Welcome~');
            console.log('home');
        }]);
});