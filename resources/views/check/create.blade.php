@extends('layouts.layout')

@section('content')

    <a href="{{ route('main.index') }}" type="button" class="mt-4 btn btn-secondary">Назад</a>


    <div class="py-5 text-center">
        <h2>Добавление в реестр</h2>
    </div>

    <div class="container-fluid">
        <h4>Введите данные:</h4>
        <form role="form" method="post" action="{{ route('check.store') }}" class="needs-validation" novalidate="">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <label for="object" class="form-label">Проверяемый СМП</label>
                    <input type="text"
                           name="object"
                           class="form-control"
                           id="object"
                           placeholder=""
                           value=""
                           required="">
                    <div class="invalid-feedback">
                        Valid first name is required.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="control" class="form-label">Контролирующий орган</label>
                    <input type="text"
                           name="control"
                           class="form-control"
                           id="control"
                           placeholder=""
                           value=""
                           required="">
                    <div class="invalid-feedback">
                        Valid last name is required.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="date_start" class="form-label">Дата начала проверки</label>
                    <input type="text"
                           name="date_start"
                           class="form-control"
                           id="date_start"
                           placeholder=""
                           value=""
                           required="">
                    <div class="invalid-feedback">
                        Valid first name is required.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="date_finish" class="form-label">Дата окончания проверки</label>
                    <input type="text"
                           name="date_finish"
                           class="form-control"
                           id="date_finish"
                           placeholder=""
                           value=""
                           required="">
                    <div class="invalid-feedback">
                        Valid last name is required.
                    </div>
                </div>

                <hr class="my-4">

                <button class="mt-4 w-100 btn btn-success btn-lg" type="submit">Добавить запись в реестр</button>

            </div>
        </form>
    </div>



@endsection
