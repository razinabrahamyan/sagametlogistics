@extends('layouts.masterLayout')

@section('title', 'Login Page')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <!-- Login v1 -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="javascript:void(0);" class="brand-logo">
                        <img src="{{asset('images/logo/logo.png?=1')}}" alt="M1-Logistics"/>
                    </a>

                    <div align="center">
                        <h4 class="card-title mb-1">Добро пожаловать в Sagamet Logistics</h4>
                        <p class="card-text mb-2">Выполните вход для работы с Логистикой</p>
                    </div>
                    <form class="auth-login-form mt-2" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="login-email" class="form-label">Почта</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                   id="login-email" name="email" placeholder="Введите свою почту"
                                   aria-describedby="login-email" tabindex="1" autofocus value="{{ old('email') }}"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="login-password"
                                       name="password" tabindex="2"
                                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                       aria-describedby="login-password"/>
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="remember-me" name="remember-me"
                                       tabindex="3" {{ old('remember-me') ? 'checked' : '' }} />
                                <label class="custom-control-label" for="remember-me">Запомни меня</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" tabindex="4">Войти</button>
                    </form>

{{--                    <div class="d-flex row justify-content-between">--}}
{{--                        <a class="m-app-icon ma-android col-5 pr-0"--}}
{{--                           href="">--}}
{{--                            <img alt='Доступно в Google Play'--}}
{{--                                 src='https://play.google.com/intl/en_us/badges/static/images/badges/ru_badge_web_generic.png'/>--}}
{{--                        </a>--}}
{{--                        <a class="m-app-icon ma-apple col-5"--}}
{{--                           href="">--}}
{{--                            <img alt="Download on the App Store"--}}
{{--                                 src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us?size=193x65&amp;releaseDate=1310601600&h=e49e169c7275536c6c3a2aac56e43a1d">--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection