<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*首页*/
Route::get('/', function () {
    return view('index');
});

/*AngularJs入口*/
Route::get('/laravel/{model}', function ($model) {

    return view('index');
});

/*PHP机器学习入口*/
Route::any('/ml', 'Ml\IndexController@index');

/*AngularJs前端接口*/
/*用户相关*/
Route::any('api/user', function () {

    return user_ins()->signup();
});

Route::post('api/user/exist', function () {

    return user_ins()->exist();
});

Route::post('api/user/signup', function () {

    return user_ins()->signup();
});

Route::any('api/user/login', function () {

    return user_ins()->login();
});

Route::any('api/user/logout', function () {

    return user_ins()->logout();
});

/*问题相关*/
Route::any('api/question/add', function () {

    return question_ins()->add();
});

Route::any('api/question/change', function () {

    return question_ins()->change();
});

Route::any('api/question/read', function () {

    return question_ins()->read();
});

Route::any('api/question/remove', function () {

    return question_ins()->remove();
});

/*回答相关*/
Route::any('api/answers/add', function () {

    return answer_ins()->add();
});

Route::any('api/answers/change', function () {

    return answer_ins()->change();
});

Route::any('api/answers/read', function () {

    return answer_ins()->read();
});


