{{--Флеш сообщения --}}

<div class="col-12">
    {{--Сессия успех--}}
    <div class="sessionFlash">
        @if (session()->has('success'))
            <div class=" alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i>Успешно!</h5>
                {{ session('success') }}
            </div>
        @endif
    </div>
    {{--/Сессия успех--}}
    {{--Сессия ошибки--}}
    @if (session()->has("error"))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Ошибка!</h5>
            @for($i = 0; $i < count(\Illuminate\Support\Facades\Session::get('error')); $i++)
            {{ $i + 1 . ":" . \Illuminate\Support\Facades\Session::get('error')[$i] }} <br>
            @endfor
        </div>
    @endif
</div>
{{--/Сессия ошибки--}}
