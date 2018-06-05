<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>Laravel</title>
    {{--<link rel="stylesheet" href="/node_modules/normalize-css/normalize.css">--}}
    {{--<script src="/node_modules/jquery/dist/jquery.js"></script>--}}
    {{--<script src="/node_modules/angular/angular.min.js"></script>--}}
    {{--<script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>--}}
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/base.css">

    {{--<script src="//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/angular.js/1.4.6/angular.min.js"></script>
    <script src="//apps.bdimg.com/libs/angular-ui-router/0.2.15/angular-ui-router.min.js"></script>
    <script src="/js/functions.js"></script>
    <script src="/js/base.js"></script>--}}
    <script data-main="/js/main.js" src="/js/libs/require.js"></script>
    <base href="/">
</head>
<body>

<div class="navbar">
    <div class="container clearfix">
        <div class="fl">
            <div class="navbar-item brand">Laravel</div>
            <div class="navbar-item">
                <input type="text">
            </div>
        </div>
        <div class="fr">
            <div ui-sref="home" class="navbar-item">首页</div>
            <div ui-sref="signup" class="navbar-item">注册</div>
            <div ui-sref="login" class="navbar-item">登录</div>
        </div>
    </div>
</div>

<div class="page">
    <div ui-view></div>
</div>

</body>
</html>