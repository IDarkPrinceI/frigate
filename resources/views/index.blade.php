@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row" style="padding-top: 40px">
            <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Перечень плановых проверок</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="mt-2 btn-group me-2">
                        {{--Кнопка добавления записей--}}
                        <button class="border-right-0 btn btn-sm btn-outline-secondary" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Добавить запись в реестр
                        </button>
                        {{--/Кнопка добавления записей--}}
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('check.create') }}">Добавить запись о проверке</a>
                            <a class="dropdown-item" href="#">Добавить объект проверки</a>
                            <a class="dropdown-item" href="#">Добавить контролирующий орган</a>
                        </div>
                        {{--Кнопка для отображения формы поиска--}}
                        <button id="findFormButton" type="button" class="btn btn-sm btn-outline-secondary">Найти
                        </button>
                        {{--/Кнопка для отображения формы поиска--}}
                        {{--Поиск--}}
                        <div id="findForm" class="d-none input-group-prepend">
                            <form method="get" action="{{ route('check.search') }}" class="form-inline">
                                <button style="border-radius: 0"
                                        class="btn btn-sm btn-outline-secondary"
                                        type="submit">Поиск
                                </button>
                                <input style="border-radius: 0; height: 31px"
                                       name="q"
                                       type="search"
                                       class="form-control"
                                       aria-label="Default"
                                       aria-describedby="inputGroup-sizing-default">
                            </form>
                        </div>
                        {{--/Поиск--}}
                        {{--Редактирование записи--}}
                        <button onclick="editCheck()" id="edit" disabled type="button"
                                class="btn btn-sm btn-outline-secondary">Редактировать
                        </button>
                        {{--/Редактирование записи--}}
                        {{--Удаление записи--}}
                        <button id="modalDell"
                                disabled
                                data-toggle="modal"
                                data-target="#dellModal"
                                type="button"
                                class="btn btn-sm btn-outline-secondary">Удалить
                        </button>
                        {{--/Удаление записи--}}
                        {{--Кнопка "сбросить поиск" для страницы search--}}
                        @if (Request::is('search'))
                            <a href="{{ route('main.index') }}" type="button" class="btn btn-sm btn-secondary">Отменить
                                поиск</a>
                        @endif
                        {{--/Кнопка "сбросить поиск" для страницы search--}}
                    </div>
                </div>
            </div>

            <div id="table" class="table-responsive border-bottom">
                @if( !is_string($checks) )
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Проверяемый СМП</th>
                            <th>Контролирующий орган</th>
                            <th>Начало проверки</th>
                            <th>Окончание проверки</th>
                            <th>Длительность</th>
                        </tr>
                        </thead>
                        <tbody id="checkBody"> {{--для передачи id в модальное окно удаления--}}
                        @php $i = request('page') ? (15 * (request('page') - 1)) + 1 : 1 @endphp
                        @foreach($checks as $check)
                            <tr data-id="{{ $check->id }}" class="checkTable">
                                <td>{{ $i }}</td>
                                <td>{{ $check->object->name }}</td>
                                <td>{{ $check->control->title }}</td>
                                <td>{{ $check->date_start }}</td>
                                <td>{{ $check->date_finish }}</td>
                                <td>{{ $check->lasting }}</td>
                            </tr>
                            @php $i++ @endphp
                        @endforeach
                        </tbody>
                    </table>
                    {{ $checks->links('vendor.pagination.bootstrap-4') }}
                    {{--                    Для вывода результатов поиска "слишком короткий запрос" и "по вашему запросу $ ничего не найдено"--}}
                @elseif( is_string($checks) )
                    <h2>{{ $checks }}</h2>
                @else
                    <h2>Реест пуст</h2>
                @endif
            </div>

        </div>
    </div>


@endsection
