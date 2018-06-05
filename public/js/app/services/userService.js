define(['laravel'], function (laravel) {
    return laravel
        .service('UserService', [
            '$state',
            '$http',
            function ($state, $http) {
                let me = this;
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
            }]);
});