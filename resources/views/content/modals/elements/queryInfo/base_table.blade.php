<table class="table col-12">
    <tr>
        <th class="text-left">Статус</th>
        <td class="text-left">
            <div class="badge query-status" style="background:{{$query->currentStatus->color}};">
                {{$query->currentStatus->title}}
            </div>
        </td>
    </tr>
    <tr>
        <th class="text-left">Имя клиента</th>
        <td class="text-left">{{$query->client_name}}</td>
    </tr>
    <tr>
        <th class="text-left">Ответсвенный менеджер</th>
        <td class="text-left">{{$query->manager->name}}</td>
    </tr>
    <tr>
        <th class="text-left">Время прибытия</th>
        <td class="text-left">{{date('d-m H:i', strtotime($query->departure_date))}}</td>
    </tr>
{{--    <tr>--}}
{{--        <th class="text-left">Время выезда с базы</th>--}}
{{--        <td class="text-left">{{(!empty($query->base_departure_date)) ? date('d-m H:i', strtotime($query->base_departure_date)) : 'Не указано'}}</td>--}}
{{--    </tr>--}}
    <tr>
        <th class="text-left">Номер телефона</th>
        <td class="text-left">
            <a class="text-decoration-underline" href="tel:{{$query->phone}}"
               title="Позвонить по номеру" data-toggle-tooltip="tooltip" data-placement="top">
                <u>{{$query->phone}}</u>
            </a>
        </td>
    </tr>
    {{--    <tr>--}}
    {{--        <th class="text-left">Нужно ли позвонить клиенту?</th>--}}
    {{--        <td class="text-left">@if($query->need_call_client == 1) Да @else Нет @endif</td>--}}
    {{--    </tr>--}}
    <tr>
        <th class="text-left">Постоянный клиент</th>
        <td class="text-left">@if($query->regular_client == 1) Да @else Нет @endif</td>
    </tr>
    <tr>
        <th class="text-left">Адрес</th>
        <td class="text-left">
            <a title="Скоприровать адрес" data-toggle-tooltip="tooltip" data-placement="top" class="popup-address"
               onclick="GFHelper.copyToClipboard('{{$query->address}}');">{{$query->address}}</a>
        </td>
    </tr>
    <tr>
        <th class="text-left">Навигация</th>
        <td class="text-left">
            @include('content.modals.elements.queryInfo.navigation_icons')
        </td>
    </tr>
    <tr>
        <th class="text-left">Тип металла</th>
        <td class="text-left">{{$query->metal->title}}</td>
    </tr>
    <tr>
        <th class="text-left">Цена</th>
        <td class="text-left">{{$query->price}}</td>
    </tr>
    <tr>
        <th class="text-left">Вес</th>
        <td class="text-left">{{$query->weight_from . ($query->weight_to ? '-' . $query->weight_to : '')}}</td>
    </tr>
    @if(!empty($query->scrap))
        <tr>
            <th class="text-left">Засор</th>
            <td class="text-left">{{$query->scrap}}</td>
        </tr>
    @endif
    <tr>
        <th class="text-left">Резчики</th>
        <td class="text-left">{{$query->cutters_count}}</td>
    </tr>
    <tr>
        <th class="text-left">Грузчики</th>
        <td class="text-left">{{$query->loaders_count}}</td>
    </tr>
    <tr>
        <th class="text-left">Кислород</th>
        <td class="text-left">{{$query->oxygen_count}}</td>
    </tr>
    <tr>
        <th class="text-left">Комментарии</th>
        <td class="text-left"><b>{{$query->comment}}</b></td>
    </tr>
    <tr>
        <th class="text-left">База</th>
        <td class="text-left">
            <a title="Скоприровать адрес" data-toggle-tooltip="tooltip" data-placement="top" class="popup-address"
               onclick="GFHelper.copyToClipboard('{{$query->base_address}}');">
                {{$query->base_address}}
            </a>
        </td>
    </tr>
</table>