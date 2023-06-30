<div id="client-details-vertical" class="content">
    <div class="form-wrapper min-vh-38">
        <div class="content-header">
            <h5 class="mb-0">Данные клиента</h5>
            <small class="text-muted">Контактные данные клиента для обратной связи</small>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="form-label" for="client_name">Ф.И.О. клиента</label>
                <input type="text" id="client_name" name="client_name" class="form-control"
                       placeholder="Введите Ф.И.О. клиента"
                       value="@if(!empty($query) && !empty($query->client_name)){{$query->client_name}}@endif"/>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="phone">Телефон</label>
                <input type="tel" id="phone" name="phone" class="form-control addQMask"
                       value="@if(!empty($query) && !empty($query->phone)){{$query->phone}}@endif"
                       placeholder="Введите номер телефона клиента"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group form-password-toggle col-md-6">
                <label for="departure_date">Дата и время выезда к клиенту</label>
                <input type="text" id="departure_date" name="departure_date" class="form-control flatpickr-date-time"
                       value="@if(!empty($query) && !empty($query->departure_date)){{$query->departure_date}}@endif"
                       placeholder="YYYY-MM-DD HH:MM"/>
            </div>
            <div class="form-group form-password-toggle col-md-6">
                <label for="base_departure_date">Дата и время выезда с базы (Для Логиста)</label>
                <input type="text" id="base_departure_date" name="base_departure_date"
                       class="form-control flatpickr-date-time"
                       value="@if(!empty($query) && !empty($query->base_departure_date)){{$query->base_departure_date}}@endif"
                       placeholder="YYYY-MM-DD HH:MM"/>
            </div>
        </div>
        {{--        <div class="row">--}}
        {{--            <div class="form-group form-password-toggle col-md-6">--}}
        {{--                <div class="custom-control custom-switch custom-switch-primary">--}}
        {{--                    <p class="mb-50">Позвонить клиенту?</p>--}}
        {{--                    <input type="checkbox" class="custom-control-input"--}}
        {{--                           name="need_call_client" id="need_call_client"--}}
        {{--                           @if(!empty($query) && $query->need_call_client == 1) checked @endif/>--}}
        {{--                    <label class="custom-control-label" for="need_call_client">--}}
        {{--                        <span class="switch-icon-left"><i data-feather="check"></i></span>--}}
        {{--                        <span class="switch-icon-right"><i data-feather="x"></i></span>--}}
        {{--                    </label>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="row">
            <div class="form-group form-password-toggle col-md-6">
                <div class="custom-control custom-switch custom-switch-primary">
                    <p class="mb-50">Постоянный клиент</p>
                    <input type="checkbox" class="custom-control-input"
                           name="regular_client" id="regular_client"
                           @if(!empty($query) && $query->regular_client == 1) checked @endif/>
                    <label class="custom-control-label" for="regular_client">
                        <span class="switch-icon-left"><i data-feather="check"></i></span>
                        <span class="switch-icon-right"><i data-feather="x"></i></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between margin-bottom-45">
        <button type="button" class="btn btn-outline-secondary btn-prev" disabled>
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Назад</span>
        </button>
        <button type="button" class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Далее</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
<div id="metal-info-vertical" class="content">
    <div class="form-wrapper min-vh-38">
        <div class="content-header">
            <h5 class="mb-0">Данные о металле</h5>
            <small>Нужны для оценки вывоза</small>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="form-label" for="metal_photos">Фотографии</label>
                @if(!empty($query) && !empty($query->photos))
                    <div class="file-uploaded-wrapper">
                        <div class="file-history">
                            <span>
                                @foreach($query->photos as $photo)
                                    <span class="file-history-lable" title="" data-file-name="{{$photo}}">
                                        <span class="file-history-title">
                                            <span class="delete_query_image"
                                                  onclick="SweetAlert.deleteQueryFile({{$query->id}},'{{$photo}}','photos')">
                                                Удалить
                                            </span>
                                        </span>
                                        @if(file_exists(public_path().'/storage/'.$photo))
                                            <img class="file-history-preview" src="{{asset('storage/'.$photo)}}"
                                                 alt="file-history-preview">
                                        @else
                                            <img class="file-history-preview" src="{{asset('images/no-image.webp')}}"
                                                 alt="file-history-preview">
                                        @endif
                                    </span>
                                @endforeach
                            </span>
                        </div>
                    </div>
                @endif
                <div class="widget-content">
                    <div class="">
                        <div class="photo-upload-previews"></div>
                        <div class="file-upload">
                            <input class="photo_upload_input with-preview" type="file" name="metal_photos[]"
                                   accept="image/png, image/jpeg, image/jpg" id="metal_photos" multiple/>
                            <span>Нажмите или перенесите фото сюда</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="metal_photos">Видео</label>
                @if(!empty($query) && !empty($query->videos))
                    <div class="file-uploaded-wrapper">
                        <div class="file-history">
                            <span>
                                @foreach($query->videos as $video)
                                    <span class="file-history-lable" title="" data-file-name="{{$video}}">
                                        <span class="file-history-title">
                                            <div class="delete_query_image"
                                                 onclick="SweetAlert.deleteQueryFile({{$query->id}},'{{$video}}','videos')">
                                                Удалить
                                            </div>
                                        </span>
                                        <video class="file-history-preview" src="{{asset('storage/'.$video)}}"></video>
                                    </span>
                                @endforeach
                            </span>
                        </div>
                    </div>
                @endif
                <div class="widget-content">
                    <div class="">
                        <div class="video-upload-previews"></div>
                        <div class="file-upload">
                            <input class="video-upload-input with-preview" type="file" name="metal_videos[]"
                                   accept="video/mp4,video/x-m4v,video/*" id="metal_videos" multiple/>
                            <span>Нажмите или перенесите видео сюда</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="form-label" for="type_of_metal">Тип метала</label>
                <select class="select2 w-100" id="type_of_metal" name="type_of_metal">
                    @foreach($metals as $metal)
                        <option value="{{$metal->id}}"
                                @if(!empty($query) && $query->type_of_metal == $metal->id) selected @endif>
                            {{$metal->title}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="price">Озвученная цена</label>
                <input type="number" min="1" step="any" pattern="\d*" id="price" name="price" class="form-control"
                       @if(!empty($query) && !empty($query->price)) value="{{$query->price}}" @endif
                       placeholder="Введите цену"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="form-label" for="weight">Вес металла</label>
                <input type="number" step="any" id="weight" name="weight" class="form-control" placeholder="Введите вес"
                       @if(!empty($query) && !empty($query->weight)) value="{{$query->weight}}" @endif/>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="scrap">Засор</label>
                <input type="text" step="any" id="scrap" name="scrap" class="form-control" placeholder="Засор"
                       @if(!empty($query) && !empty($query->scrap)) value="{{$query->scrap}}" @endif/>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between margin-bottom-45">
        <button type="button" class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Назад</span>
        </button>
        <button type="button" class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Далее</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
<div id="address-step-vertical" class="content">
    <div class="form-wrapper min-vh-38">
        <div class="content-header">
            <h5 class="mb-0">Геолокация</h5>
            <small>Оперделение точки вывоза и ввоза метала</small>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="form-label" for="address">Адрес</label>
                <input type="text" id="address" name="address" class="form-control"
                       value="@if(!empty($query) && !empty($query->address)){{$query->address}}@endif"
                       placeholder="Введите текст для начала поиска" autocomplete="no"/>
                @include('content.query.queryWizardForms.elements.auto_maping_select')
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="base">Выбор базы</label>
                <input type="text" id="base" name="base_address" class="form-control"
                       @if(!empty($query) && !empty($query->base_address))
                       value="{{$query->base_address}}"
                       @endif
                       placeholder="Введите текст для начала поиска" autocomplete="no"/>
                @include('content.query.queryWizardForms.elements.base_maping_select')
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="custom_latitude">Широта (необязательно)</label>
                <input type="text" id="custom_latitude" name="custom_latitude" class="form-control"
                       value="@if(!empty($query) && !empty($query->address_points) && isset($query->address_points->custom_latitude)){{$query->address_points->custom_latitude}}@endif"
                       placeholder="Пример: 55.752004" autocomplete="no"/>
            </div>
            <div class="form-group col-md-6">
                <label class="form-label" for="custom_longitude">Долгота (необязательно)</label>
                <input type="text" id="custom_longitude" name="custom_longitude" class="form-control"
                       value="@if(!empty($query) && !empty($query->address_points) && isset($query->address_points->custom_longitude)){{$query->address_points->custom_longitude}}@endif"
                       placeholder="Пример: 37.617734" autocomplete="no"/>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between margin-bottom-45">
        <button type="button" class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Назад</span>
        </button>
        <button type="button" class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Далее</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
<div id="team-links-vertical" class="content">
    <div class="form-wrapper min-vh-38">
        <div class="content-header">
            <h5 class="mb-0">Сбор команды</h5>
            <small>Формирование команды для вывоза меттала</small>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label class="form-label" for="cutters_count">Резчики</label>
                <input type="number" id="cutters_count" name="cutters_count" class="form-control" pattern="\d*"
                       @if(!empty($query) && !empty($query->cutters_count))
                       value="{{$query->cutters_count}}"
                       @else value="0" @endif/>
            </div>
            <div class="form-group col-md-4">
                <label class="form-label" for="loaders_count">Грузчики</label>
                <input type="number" id="loaders_count" name="loaders_count" class="form-control" pattern="\d*"
                       @if(!empty($query) && !empty($query->loaders_count)) value="{{$query->loaders_count}}"
                       @else value="0" @endif/>
            </div>
            <div class="form-group col-md-4">
                <label class="form-label" for="oxygen_count">Кислород</label>
                <input type="number" id="oxygen_count" name="oxygen_count" class="form-control" pattern="\d*"
                       @if(!empty($query) && !empty($query->oxygen_count)) value="{{$query->oxygen_count}}"
                       @else value="0" @endif"/>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between margin-bottom-45">
        <button type="button" class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Назад</span>
        </button>
        <button type="button" class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Далее</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
<div id="machines-links-vertical" class="content">
    <div class="form-wrapper min-vh-38">
        <div class="content-header">
            <h5 class="mb-0">Сбор техники</h5>
            <small>Формирование техники для выезда к клиенту</small>
        </div>
        @foreach($machines as $machine)
            <div class="row">
                <div class="form-group col-md-9">
                    <label class="form-label" for="{{$machine->title_en}}_driver">{{$machine->title}}</label>
                    <select class="select2 w-100 smartsearch_keyword" id="{{$machine->title_en}}_driver"
                            onchange="QueryHandler.driverChangeEvent(this)"
                            name="machines[{{$machine->title_en}}][drivers][]"
                            data-machine-type="{{$machine->title_en}}" multiple>
                        @foreach($machine->drivers as $driver)
                            <option value="{{$driver->id}}"
                                    @if(!empty($query) && isset($query->machines->{$machine->title_en}) && in_array($driver->id,$query->machines->{$machine->title_en}->drivers))
                                    selected @endif>
                                {{$driver->full_name.' ('.$driver->car_numbers.')'}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label class="form-label" for="{{$machine->title_en}}_count">Кол.</label>
                    <input type="number" id="{{$machine->title_en}}_count" pattern="\d*"
                           name="machines[{{$machine->title_en}}][count]" class="form-control machine-count"
                           data-machine-type="{{$machine->title_en}}"
                           @if(!empty($query) && isset($query->machines->{$machine->title_en}))
                           value="{{$query->machines->{$machine->title_en}->count}}"
                           @else value="0" @endif"/>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-between margin-bottom-45">
        <button type="button" class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Назад</span>
        </button>
        <button type="button" class="btn btn-primary btn-next">
            <span class="align-middle d-sm-inline-block d-none">Далее</span>
            <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
        </button>
    </div>
</div>
<div id="additional-links-vertical" class="content">
    <div class="form-wrapper min-vh-38">
        <div class="content-header">
            <h5 class="mb-0">Дополнительная информация</h5>
            <small>Дополнение заявки для большей информативности</small>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="form-label" for="comment">Напишите комментарий к заявке</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Введите комментарии"
                          style="max-height: 185px;min-height: 90px"
                >@if(!empty($query) && !empty($query->comment)){{$query->comment}}@endif</textarea>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between margin-bottom-45">
        <button type="button" class="btn btn-primary btn-prev">
            <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
            <span class="align-middle d-sm-inline-block d-none">Назад</span>
        </button>
        <button id="form_submit" type="button" class="btn btn-success btn-submit" onclick="GFHelper.submitForm(this)">
            Сохранить
        </button>
    </div>
</div>