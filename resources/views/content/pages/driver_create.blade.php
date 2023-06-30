@extends('layouts.core')
@section('title', 'Редактирование водителя')
@section('content')
    <form action="{{route('drivers.store')}}" class="driver_form needs-validation" method="POST">
        @csrf
        @include('content.drivers.driverFormSection')
    </form>
@endsection