<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--Meta--}}
    <title>@yield('title')</title>

    {{--Scripts--}}
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    {{--Styles--}}

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="container-fluid" id="app">
    @yield('layout')
</div>
<footer>
    
</footer>
@yield('footer-scripts')
</body>
</html>