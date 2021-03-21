{{--Подключаемая форма выпадающего списка--}}
<button style="width: 300px" class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="true">Выберите проверяемый субъект
</button>

<div style="overflow-y: scroll; max-height: 200px;"
     id="dropDownObject"
     class="dropdown-menu">
    @if(gettype($objects) === 'string')
        <li class="dropdown-item">Введите название</li>
    @else
        @foreach($objects as $object)
            <li class="dropdown-item" style="cursor: pointer" value="{{ $object->id }}">{{ $object->name }}</li>
        @endforeach
    @endif
</div>
