@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts.masterLayout')

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-misc.css')) }}">
@endsection
@section('content')
    <div class="misc-wrapper">
        <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">Упс! Что-то пошло не так...</h2>
                <p class="mb-1">{{$error}}</p>
                <a class="btn btn-primary mb-2 btn-sm-block" href="{{url('/')}}">Вернуться на домашнюю страницу</a>
                <img class="img-fluid" src="{{asset('images/pages/error-dark.svg')}}" alt="Error page"/>
            </div>
        </div>
    </div>
@endsection
