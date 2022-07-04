
@php $messageName = $messageName ?? "page-message";@endphp
    @if(\Illuminate\Support\Facades\Session::has($messageName))
        @php $data = \Illuminate\Support\Facades\Session::get($messageName);@endphp
        <div class="alert alert-dismissible alert-{{$data["status"]}} page-message {{$data["status"]}}" >
            <button class="close" type="button" data-dismiss="alert">×</button>
            {{$data["message"]}}.
        </div>
    @endif
