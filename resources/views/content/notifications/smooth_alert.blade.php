@if(session()->has('alertMessage'))
    <input type="hidden" id="alertMessage" value="{{session()->get('alertMessage')}}">
@else
    <input type="hidden" id="alertMessage" value="">
@endif
