
        <div class="dropdown-menu">
{{--            @if(!empty($checkObjects))--}}
                @foreach($objects as $object)
                    <a class="dropdown-item" href="#">{{ $object->name }}</a>
                @endforeach
{{--            @endif--}}
        </div>
