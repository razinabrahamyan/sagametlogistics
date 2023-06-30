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
    <meta name="HandheldFriendly" content="true"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#283046">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#283046">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#283046">

    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/meta/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('images/meta/apple-touch-icon.png')}}">
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('favicon-32x32.png')}}" type="image/png">
    <link rel="icon" href="{{asset('maskable_icon_x128.png')}}" type="image/png">
    <link rel="canonical" href="{{url()->full()}}">
    <link rel="manifest" href="{{asset('manifest.json').'?id=1'}}">
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
    @include('content.navbar.sidebar')
@endif

@include('content.navbar.navbar')

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

@can('showPersonal')
    <a href="https://api.whatsapp.com/send?phone={{\App\Classes\Constants\WhatsAppConstants::LOGISTIC_NUMBER}}"
       class="ppt-item whatsapp-fix rotate-i pptItemVisible" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="#ffffff"
             class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
        </svg>
    </a>
@endcan

@include('content.panels.scripts')

<script type="text/javascript">
    $(window).on('load', function () {
        /*Init Login Event*/
        @if(!empty(request()->get('eventLogin')))
        const eventLogin = new Event('eventLogin');
        document.addEventListener('eventLogin', function (e) {
            if (window.ReactNativeWebView !== undefined) {
                window.ReactNativeWebView.postMessage(JSON.stringify({
                    'eventName': 'eventLogin',
                    'userId': {{auth()->id()}},
                }))
            }
        }, false);

        document.dispatchEvent(eventLogin);
        @endif
        /*Init Login Event*/

        featherSVG(14);

        /*PWA INSTALLER*/
        //Определим кнопку
        const installApp = document.getElementById('pwa-install');
        var deferredPrompt;

        //Событие вызова окна установки
        window.addEventListener('beforeinstallprompt', function (e) {
            $('#pwa-install').removeClass('d-none')
            e.preventDefault();
            deferredPrompt = e;
            return false;
        });

        installApp.addEventListener('click', function () {
            if (deferredPrompt !== undefined) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(function (choiceResult) {
                    if (choiceResult.outcome == 'dismissed') {
                        //
                    } else {
                        $('#pwa-install').hide()
                    }
                    deferredPrompt = null;
                });
            }
        });

        if (deferredPrompt !== undefined) {
            //Если приложение нельзя установить или оно уже установлено, то скрываем кнопку
            $('#pwa-install').removeClass('d-none')
        }

        /*PWA INSTALLER*/
    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
@stack('vue')
</body>

</html>
