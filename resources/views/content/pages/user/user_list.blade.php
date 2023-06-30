@extends('layouts.core')
@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            <section id="dashboard-ecommerce">
                <div class="row match-height">
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="row" id="basic-table">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Список пользователей</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
{{--                                                <th>Аватар</th>--}}
                                                <th>Имя</th>
                                                <th>Роль</th>
                                                <th>Email</th>
                                                <th>Статус</th>
                                                <th>Действия</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @foreach($users as $user)
{{--                                                    <td>--}}
{{--                                                        <div class="avatar-group">--}}
{{--                                                            <div data-toggle="tooltip" data-popup="tooltip-custom"--}}
{{--                                                                 data-placement="top" title=""--}}
{{--                                                                 class="avatar pull-up my-0"--}}
{{--                                                                 data-original-title="{{$user->name}}">--}}
{{--                                                                @if(!empty($user->avatar))--}}
{{--                                                                    <img src="{{asset(\Illuminate\Support\Facades\Storage::url($user->avatar))}}"--}}
{{--                                                                         alt="Avatar" height="50" width="50"/>--}}
{{--                                                                @else--}}
{{--                                                                    <img src="{{asset('images/avatars/default_avatar.png')}}"--}}
{{--                                                                         alt="Avatar" height="50" width="50"/>--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
                                                    <td>{{$user->name}}</td>
                                                    <td>
                                                        <span class="text-info">{{$user->role['title']}}</span>
                                                    </td>
                                                    <td>
                                                        {{$user->email}}
                                                    </td>
                                                    <td>
                                                        @if(empty($user->deleted_at))
                                                            <span class="text-success">Активный</span>
                                                        @else
                                                            <span class="text-danger">Удален</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm dropdown-toggle hide-arrow"
                                                                    data-toggle="dropdown">
                                                                <i data-feather="more-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @if(empty($user->deleted_at))
                                                                    <a class="dropdown-item"
                                                                       href="{{route('user.edit', $user->id)}}">
                                                                        <i data-feather="edit-2" class="mr-50"></i>
                                                                        <span>Изменить</span>
                                                                    </a>
                                                                    <a class="dropdown-item"
                                                                       href="{{route('user.delete',[$user->id])}}">
                                                                        <i data-feather="trash" class="mr-50"></i>
                                                                        <span>Удалить</span>
                                                                    </a>
                                                                @else
                                                                    <a class="dropdown-item"
                                                                       href="{{route('user.recover',[$user->id])}}">
                                                                        <i data-feather='refresh-cw' class="mr-50"></i>
                                                                        <span>Восстановить</span>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
@endsection