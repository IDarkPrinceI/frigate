@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row" style="padding-top: 40px">
            <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Перечень плановых проверок</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('check.create') }}" type="button" class="btn btn-sm btn-outline-secondary">Добавить
                            запись в реестр</a>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        <button onclick="dellEdit()" id="edit" disabled type="button" class="btn btn-sm btn-outline-secondary">Редактировать</button>
                        <button id="modalDell"
                                disabled
                                data-toggle="modal"
                                data-target="#dellModal"
                                type="button"
                                class="btn btn-sm btn-outline-secondary">Удалить</button>
                    </div>
                </div>
            </div>
            <div id="table" class="table-responsive border-bottom">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Проверяемый СМП</th>
                        <th>Контролирующий орган</th>
                        <th>Начало проверки</th>
                        <th>Окончание проверки</th>
                        <th>Длительность</th>
{{--                        <th id="checkActionsBar">Действия</th>--}}
                    </tr>
                    </thead>
                    <tbody id="checkBody"> {{--для передачи id в модальное окно удаления--}}
                    @php $i = request('page') ? (5 * (request('page') - 1)) + 1 : 1 @endphp
                    @foreach($checks as $check)
                        <tr data-id="{{ $check->id }}" class="checkTable">
                            <td>{{ $i }}</td>
                            <td>{{ $check->object }}</td>
                            <td>{{ $check->control }}</td>
                            <td>{{ $check->date_start }}</td>
                            <td>{{ $check->date_finish }}</td>
                            <td>5</td>
                            <td class="test" id="checkActions">
{{--                                <div class="btn-group">--}}
{{--                                    --}}{{--Редактирование--}}
{{--                                    <a id="test"--}}
{{--                                       href="{{ route('check.edit', ['id' => $check->id]) }}"--}}
{{--                                       class="btn btn-warning mr-1 rounded-right"><i class="fas fa-pen"></i>--}}
{{--                                    </a>--}}
                                    {{--/Редактирование--}}
                                    {{--Удалить--}}
{{--                                    <button id="modalDell"--}}
{{--                                            class="btn btn-danger rounded-left"                                                       type="button"--}}
{{--                                            data-id="{{ $check->id }}"--}}
{{--                                            data-toggle="modal"--}}
{{--                                            data-target="#dellModal">--}}
{{--                                        <i data-id="{{ $check->id }}"--}}
{{--                                           class="fas fa-trash">--}}
{{--                                        </i>--}}
{{--                                    </button>--}}
                                    {{--/Удалить--}}
{{--                                </div>--}}
                            </td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
