<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{--csrf token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{--css--}}
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    {{--/css--}}

</head>
<body>

{{--@include('layouts.header')--}}

@include('layouts.sidebar')

@yield('content')

{{--@include('layouts.footer')--}}

{{--js--}}
<script src={{ asset('assets/js/jquery-3.5.1.min.js') }}></script>
<script src={{ asset('assets/js/bootstrap.js') }}></script>
<script src={{ asset('assets/js/bootstrap.min.js') }}></script>
<script src={{ asset('assets/js/main.js') }}></script>

{{--/js--}}

</body>
</html>
