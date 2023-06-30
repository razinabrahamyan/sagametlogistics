<section class="app-user-edit">
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <form class="form-validate" action="{{route('profile.save')}}" method="POST"
                          enctype="multipart/form-data">
                        <input type="hidden" value="{{auth()->id()}}" name="id" id="id" required/>
                        @csrf
                        <div class="media mb-2">
                            <img src="{{\App\Classes\Auth\AuthorizedUser::getUserAvatar()}}"
                                 class="avatar avatar-bordered user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"
                                 height="90"
                                 width="90" alt="avatar" id="avatar"/>
                            <div class="media-body mt-50">
                                <h4>
                                    {{\App\Classes\Auth\AuthorizedUser::getUserName()}}
                                    ( {{\App\Classes\Auth\AuthorizedUser::getUserRoleTitle()}} )
                                </h4>
                                <div class="col-12 d-flex mt-1 px-0">
                                    <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                        <span class="d-none d-sm-block">Изменить</span>
                                        <input class="form-control" type="file" name="avatar" id="change-picture" hidden
                                               onchange="imageHandler.changeImageOnInput(this,'#avatar,.avatar .round')"
                                               accept="image/png, image/jpeg, image/jpg"/>
                                        <span class="d-block d-sm-none">
                                        <i class="mr-0" data-feather="edit"></i>
                                    </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Ф.И.О.</label>
                                    <input type="text" class="form-control" placeholder="Введите Ф.И.О."
                                           value="{{\App\Classes\Auth\AuthorizedUser::getUserName()}}"
                                           name="name" id="name" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Номер телефона</label>
                                    <input type="tel" class="form-control" placeholder="Номер телефона"
                                           value="{{\App\Classes\Auth\AuthorizedUser::getUserPhone()}}"
                                           name="phone" id="phone" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" placeholder="Email"
                                           value="{{\App\Classes\Auth\AuthorizedUser::getUserMail()}}"
                                           name="email" id="email" required/>
                                </div>
                            </div>
                            {{--                            <div class="col-md-4">--}}
                            {{--                                <div class="form-group">--}}
                            {{--                                    <label for="password">Новый пароль</label>--}}
                            {{--                                    <input type="text" class="form-control" minlength="6"--}}
                            {{--                                           placeholder="Введите новый пароль" name="password" id="password"/>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>