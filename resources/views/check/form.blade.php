{{--Подключаемая форма ввода атрибутов--}}
<div class="row">
    {{--Название СМП--}}
    <div class="col-md-12">
        <label for="object" class="form-label">Проверяемый СМП</label>
        <div class="input-group">
            <div id="divObject" class="input-group-prepend">
                @include('check.includeObject')
            </div>
            <input id="inputObject" type="text" class="form-control"
                   placeholder="Поиск...">
            <input name="object"
                   id="object"
                   type="text"
                   class="form-control @error('object') is-invalid @enderror"
                   placeholder="Выбранный проверяемый СМП"
                   value="{{ $check->object->name ?? old('object') }}"
                   readonly
            >
        </div>
    </div>
    {{--/Название СМП--}}
    {{--Контролирующий орган--}}
    <div class="col-md-12">
        <label for="control" class="form-label">Контролирующий орган</label>
        <div class="input-group">
            <div id="divControl" class="input-group-prepend">
                @include('check.includeControl')
            </div>
            <input id="inputControl" type="text" class="form-control"
                   placeholder="Поиск...">
            <input name="control"
                   id="control"
                   type="text"
                   class="form-control @error('control') is-invalid @enderror"
                   placeholder="Выбранный контролирующий орган"
                   value="{{ $check->control->title ?? old('control') }}"
                   readonly>
        </div>
    </div>
    {{--/Контролирующий орган--}}
    {{--Дата начала проверки--}}
    <div class="col-md-6 mt-3">
        <label for="date_start" class="form-label">Дата начала проверки</label>
        <input type="text"
               name="date_start"
               class="form-control @error('date_start') is-invalid @enderror"
               id="date_start"
               placeholder="Выберите дату начала"
               value="{{ $check->date_start ?? old('date_start') }}"
               required=""
               autocomplete="off">
        <div class="invalid-feedback">
            Valid first name is required.
        </div>
    </div>
    {{--/Дата начала проверки--}}
    {{--Дата окончания проверки--}}
    <div class="col-md-6 mt-3">
        <label for="date_finish" class="form-label">Дата окончания проверки</label>
        <input type="text"
               name="date_finish"
               class="form-control @error('date_finish') is-invalid @enderror"
               id="date_finish"
               placeholder="Выберите дату окончания"
               value="{{ $check->date_finish ?? old('date_finish') }}"
               required=""
               autocomplete="off">
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
