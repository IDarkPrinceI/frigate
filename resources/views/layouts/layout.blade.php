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
    <script src="https://kit.fontawesome.com/6a83091d59.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    {{--/css--}}

</head>
<body>

{{--@include('layouts.header')--}}

{{--@include('layouts.sidebar')--}}
<div class="container">
@yield('content')
    </div>
{{--@include('layouts.footer')--}}

{{--Модальное окно удаления--}}
<div class="modal fade" id="dellModal" tabindex="-1" role="dialog" aria-labelledby="dellModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Подтверждение удаления</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Вы действительно хотите удалить выбранную запись? <br>
                Эта операция необратима
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button onclick="dellCheck()" id="dellButton" type="button" class="btn btn-danger">Подтвердить удаление</button>
            </div>
        </div>
    </div>
</div>
{{--Модальное окно удаления--}}


{{--js--}}
<script src={{ asset('assets/js/jquery-3.5.1.min.js') }}></script>
{{--<script src={{ asset('assets/js/bootstrap.bundle.js') }}></script>--}}
<script src={{ asset('assets/js/bootstrap.bundle.min.js') }}></script>
<script src={{ asset('assets/js/bootstrap.js') }}></script>
<script src={{ asset('assets/js/bootstrap.min.js') }}></script>
<script src={{ asset('assets/js/jquery-ui.min.js') }}></script>  {{--календарь--}}
<script src={{ asset('assets/js/jquery.ui.datepicker-ru.js') }}></script> {{--календарь--}}
<script src={{ asset('assets/js/main.js') }}></script>  {{--мои скрипты--}}

{{--/js--}}

</body>
</html>
