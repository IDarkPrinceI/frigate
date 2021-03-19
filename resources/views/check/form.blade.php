{{--Подключаемая форма ввода атрибутов--}}
<div class="row">
    {{--Название СМП--}}
    <div class="col-md-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Выберите СМП
                </button>
                <div id="divObject">
                    @include('check.include')

                </div>

                {{--                <div class="dropdown-menu">--}}
{{--                    @if(!empty($checkObjects))--}}
{{--                        @foreach($checkObjects as $object)--}}
{{--                            <a class="dropdown-item" href="#">{{ $object->name }}</a>--}}
{{--                            <a class="dropdown-item" href="#">Another action</a>--}}
{{--                            <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                            <div role="separator" class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#">Separated link</a>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                </div>--}}
                <input id="inputObject" type="text" class="form-control" aria-label="Text input with dropdown button">
            </div>
        </div>


        <label for="object" class="form-label">Проверяемый СМП</label>
        <select
            name="object"
            class="form-control @error('object') is-invalid @enderror"
            id="object">
            @if( empty($check) )
                <option
                    selected="true"
                    disabled="disabled">Выберите СМП
                </option>
            @endif
            {{--Выпадающий список--}}
            @foreach($objects as $key => $object)
                <option
                    @if( !empty($check) && $check->object_id == $object->id) selected @endif
                @if( old('object') && old('object') == $object->id) selected @endif
                    id="{{ $object->id }}"
                    value="{{ $object->id }}"
                >{{ $object->name }}
                </option>
            @endforeach
            {{--Выпадающий список--}}
            <div class="invalid-feedback">
                Valid first name is required.
            </div>
        </select>
    </div>
    {{--/Название СМП--}}
    {{--Контролирующий орган--}}
    <div class="col-md-6">
        <label for="control" class="form-label">Контролирующий орган</label>
        <select
            name="control"
            class="form-control @error('control') is-invalid @enderror"
            id="control">
            @if( empty($check) )
                <option
                    selected="true"
                    disabled="disabled">Выберите контролирующий орган
                </option>
            @endif
            {{--Выпадающий список--}}
            @foreach($controls as $key => $control)
                <option
                    @if( !empty($check) && $check->control_id == $control->id) selected @endif
                @if( old('control') && old('control') == $control->id) selected @endif
                    id="{{ $control->id }}"
                    value="{{ $control->id }}"
                >{{ $control->title }}
                </option>
            @endforeach
            {{--Выпадающий список--}}
            <div class="invalid-feedback">
                Valid first name is required.
            </div>
        </select>
    </div>
    {{--/Контролирующий орган--}}
    {{--Дата начала проверки--}}
    <div class="col-md-6">
        <label for="date_start" class="form-label">Дата начала проверки</label>
        <input type="text"
               name="date_start"
               class="form-control @error('date_start') is-invalid @enderror"
               id="date_start"
               placeholder="Выберите дату начала"
               value="{{ $check->date_start ?? old('date_start') }}"
               required="">
        <div class="invalid-feedback">
            Valid first name is required.
        </div>
    </div>
    {{--/Дата начала проверки--}}
    {{--Дата окончания проверки--}}
    <div class="col-md-6">
        <label for="date_finish" class="form-label">Дата окончания проверки</label>
        <input type="text"
               name="date_finish"
               class="form-control @error('date_finish') is-invalid @enderror"
               id="date_finish"
               placeholder="Выберите дату окончания"
               value="{{ $check->date_finish ?? old('date_finish') }}"
               required="">
        <div class="invalid-feedback">
            Valid last name is required.
        </div>
    </div>
    {{--/Дата окончания проверки--}}

    <hr class="my-4">

    <button class="mt-4 w-100 btn btn-secondary btn-lg" type="submit">
        @if( !empty($check) ) Сохранить изменения в реестр
        @else Добавить запись в реестр
        @endif
    </button>
</div>
