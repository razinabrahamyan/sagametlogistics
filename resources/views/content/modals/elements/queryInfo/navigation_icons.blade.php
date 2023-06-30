@if(!empty($query->address_points))
    @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
        <div class="row">
            {{--Google--}}
            <a href="https://www.google.com/maps?saddr=My+Location&daddr={{$query->address_points->custom_latitude ?? $query->address_points->latitude}},{{$query->address_points->custom_longitude ?? $query->address_points->longitude}}"
               target="_blank">
                <img class="nav-logos" src="{{asset("/images/logo/goolge_maps_logo.png")}}">
            </a>
            {{--2Gis--}}
            <a href="//2gis.ru/routeSearch/rsType/car/to/{{$query->address_points->custom_longitude ?? $query->address_points->longitude}},{{$query->address_points->custom_latitude ?? $query->address_points->latitude}}">
                <img class="nav-logos" src="{{asset("/images/logo/2GIS_logo.jpg")}}">
            </a>
        </div>
    @endif
@endif
<div class="row">
    @if(!empty($query->address_points))
        @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
            {{--Yandex Navigator--}}
            <a href="yandexnavi://build_route_on_map?lat_to={{$query->address_points->custom_latitude ?? $query->address_points->latitude}}&lon_to={{$query->address_points->custom_longitude ?? $query->address_points->longitude}}">
                <img class="nav-logos" src="{{asset("/images/logo/yandex_navi_logo.png")}}">
            </a>
        @endif
    @endif
    {{--Yandex Maps--}}
    @if(!empty($query->address_points->custom_latitude) && !empty($query->address_points->custom_longitude))
        <a href="https://yandex.ru/maps/?text={{$query->address_points->custom_latitude}},{{$query->address_points->custom_longitude}}&rtt=mt"
           target="_blank">
            <img class="nav-logos" src="{{asset("/images/logo/yandex_maps_logo.png")}}">
        </a>
    @else
        <a target="_blank" href="https://yandex.ru/maps/?text={{$query->address}}">
            <img class="nav-logos" src="{{asset("/images/logo/yandex_maps_logo.png")}}">
        </a>
    @endif
</div>