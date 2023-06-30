@isset($pageConfigs)
{!! \App\Helpers\Helper::updatePageConfig($pageConfigs) !!}
@endisset

        <!DOCTYPE html>
{{-- {!! Helper::applClasses() !!} --}}
@php
    $configData = \App\Helpers\Helper::applClasses();
@endphp

<html lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
      data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}"
      class="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    {{-- Include core + vendor Styles --}}
    @include('content.panels.styles')

    {{--preloader--}}
    <script>
        window.onload = function () {
            document.body.classList.add('loaded_hiding');
            window.setTimeout(function () {
                document.body.classList.add('loaded');
                document.body.classList.remove('loaded_hiding');
            }, 500);
        }
    </script>
</head>


<body class="vertical-layout vertical-menu-modern {{ $configData['showMenu'] === true ? '2-columns' : '1-column' }}
{{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}
{{ $configData['verticalMenuNavbarType'] }}
{{ $configData['sidebarClass'] }} {{ $configData['footerType'] }}" data-menu="vertical-menu-modern"
      data-col="{{ $configData['showMenu'] === true ? '2-columns' : '1-column' }}"
      data-layout="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
      style="{{ $configData['bodyStyle'] }}" data-framework="laravel" data-asset-path="{{ asset('/')}}">

<input type="hidden" value="{{\Illuminate\Support\Facades\Auth::user()}}" id="auth-user-data">

<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>


@if((isset($configData['showMenu']) && $configData['showMenu'] === true))
    @include('personnelContent.navbar.sidebar')
@endif

@include('personnelContent.navbar.navbar')

<!-- BEGIN: Content-->
<div class="app-content content {{ $configData['pageClass'] }}">
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
        <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-wrapper">
                    <div class="content-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
            {{--            @if($configData['pageHeader'] === true && isset($configData['pageHeader']))--}}
            {{--                @include('content.navbar.breadcrumb')--}}
            {{--            @endif--}}

            <div class="content-body">
                @yield('content')
                @include('content.notifications.smooth_alert')
            </div>
        </div>
    @endif

</div>
<div class="sidenav-overlay"></div>
{{--<div class="drag-target"></div>--}}
@include('content.panels.footer')

@include('content.panels.scripts')

<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14
                , height: 14
            });
        }
    })

</script>
</body>

</html>
