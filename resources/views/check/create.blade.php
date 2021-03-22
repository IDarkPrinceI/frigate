@extends('layouts.layout')

@section('content')

    {{--Хлебные крошки--}}
    <div class="mt-5 float-right">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-secondary" href="{{ route('main.index') }}">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавление проверки в реестр</li>
            </ol>
        </nav>
    </div>
    {{--/Хлебные крошки--}}
    <div class="py-5">
        <h2>Добавление проверки в реестр</h2>
    </div>
    <div class="container-fluid">
        <h4>Введите данные:</h4>
        <form role="form" method="post" action="{{ route('check.store') }}" class="needs-validation" novalidate="">
            @csrf
            {{--Подключаемая форма ввода атрибутов--}}
            @include('check.form')
        </form>
    </div>

@endsection
