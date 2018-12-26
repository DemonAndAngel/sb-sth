<!doctype html>
<html lang="zh-cn" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}">
    <title>@yield('title',($pageInfo['title']??''))</title>
    <style>
        #app{
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-content: center;
        }
    </style>
    @yield('style')
</head>
<body style="height: 100%;">
<div id="app">
    <layout-header
            active_name="{{ $pageInfo['active_name']??'index' }}"
            :user_data="{{ $pageInfo['user_data'] }}"
    ></layout-header>
    @yield('content')
    <layout-footer></layout-footer>
</div>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
@yield('script')
</body>
</html>