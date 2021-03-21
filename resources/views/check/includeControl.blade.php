{{--Подключаемая форма выпадающего списка--}}
<button style="width: 300px" class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="true">Выберите контролирующий орган
</button>

<div style="overflow-y: scroll; max-height: 200px;"
     id="dropDownControl"
     class="dropdown-menu">
    @if(gettype($controls) === 'string')
        <li class="dropdown-item">Введите название</li>
    @else
        @foreach($controls as $control)
            <li class="dropdown-item" style="cursor: pointer" value="{{ $control->id }}">{{ $control->title }}</li>
        @endforeach
    @endif
</div>
