<nav class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle" href="javascript:void(0);">
                        <i class="ficon" data-feather="menu"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav list-inline text-center d-flex justify-content-center align-items-center ml-1 ml-md-0">
                <li class="nav-item  d-lg-block list-inline-item">
                    <a id="theme-mode" class="nav-link nav-link-style pl-0">
                        <i class="ficon" data-feather="{{($configData['theme'] === 'dark') ? 'sun' : 'moon' }}"></i>
                    </a>
                </li>
                <li id="mute-mode" class="nav-item  d-lg-block list-inline-item">
                    <a class="nav-link pl-0" onclick="AlertNotification.muteSoundTrigger()">
                        <i id="mute-off" data-feather='volume-2'></i>
                        <i id="mute-on" data-feather='volume-x'></i>
                    </a>
                </li>
                <li class="nav-item list-inline-item">
                    <button id="pwa-install" class="btn btn-sm btn-success d-none">
                        Установить <br class="d-block d-md-none"> приложение
                    </button>
                </li>
                {{--                <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon"--}}
                {{--                                                                                       data-feather="search"></i></a>--}}
                {{--                    <div class="search-input">--}}
                {{--                        <div class="search-input-icon"><i data-feather="search"></i></div>--}}
                {{--                        <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="-1"--}}
                {{--                               data-search="search">--}}
                {{--                        <div class="search-input-close"><i data-feather="x"></i></div>--}}
                {{--                        <ul class="search-list search-list-main"></ul>--}}
                {{--                    </div>--}}
                {{--                </li>--}}
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-notification mr-25">
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block" href="javascript:void(0)">Read
                            all notifications</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{\App\Classes\Auth\AuthorizedUser::getUserName()}}</span>
                        <span class="user-status">{{\App\Classes\Auth\AuthorizedUser::getUserRoleTitle()}}</span>
                    </div>
                    <span class="avatar avatar-bordered">
              <img class="round"
                   src="{{\App\Classes\Auth\AuthorizedUser::getUserAvatar()}}" alt="avatar"
                   height="40"
                   width="40">
              <span class="avatar-status-online"></span>
            </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{route('profile')}}">
                        <i class="mr-50" data-feather="user"></i> Профиль
                    </a>
                    {{--            <a class="dropdown-item" href="{{url('app/email')}}">--}}
                    {{--              <i class="mr-50" data-feather="mail"></i> Inbox--}}
                    {{--            </a>--}}
                    {{--            <a class="dropdown-item" href="{{url('app/todo')}}">--}}
                    {{--              <i class="mr-50" data-feather="check-square"></i> Task--}}
                    {{--            </a>--}}
                    {{--           --}}
                    {{--            <a class="dropdown-item" href="{{url('app/chat')}}">--}}
                    {{--              <i class="mr-50" data-feather="message-square"></i> Чаты--}}
                    {{--            </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('page/account-settings')}}">
                                  <i class="mr-50" data-feather="settings"></i> Настройки
                                </a>
                    {{--            <a class="dropdown-item" href="{{url('page/pricing')}}">--}}
                    {{--              <i class="mr-50" data-feather="credit-card"></i> Pricing--}}
                    {{--            </a>--}}
                    <a class="dropdown-item" href="#">
                        <i class="mr-50" data-feather="help-circle"></i> FAQ
                    </a>
                    <a class="dropdown-item" href="{{url('auth/logout')}}">
                        <i class="mr-50" data-feather="power"></i> Выйти
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

{{-- if main search not found! --}}
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between">
        <a class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start">
                <span class="mr-75" data-feather="alert-circle"></span>
                <span>No results found.</span>
            </div>
        </a>
    </li>
</ul>
{{-- Search Ends --}}
<!-- END: Header-->
</nav>