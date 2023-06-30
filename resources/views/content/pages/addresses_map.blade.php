@extends('layouts.core')
@section('title', 'Добро пожаловать')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/base/pages/app-invoice-list.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
          integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
@endsection

@section('content')
    <section id="addresses_filter_section" class="invoice-list-wrapper mw-100">
        <div class="card">
            <div class="card-datatable table-responsive">
                <br/>
                <div class="row m-0" id="custom_filters">
                    <label class="col-12">Фильтрация по дате вывоза</label>
                    <div class="col-12 mb-1">
                        <div id="departure_date_filter" class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-primary dep_day_lable active" id="date_filter_label_today">
                                <input type="radio" name="fast_date_filter" id="radio_option_today" value="today"
                                       checked/>Сегодня
                            </label>
                            <label class="btn btn-outline-primary dep_day_lable" id="date_filter_label_tomorrow">
                                <input type="radio" name="fast_date_filter" id="radio_option_tomorrow"
                                       value="tomorrow"/>Завтра
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="addresses_map_section" class="invoice-list-wrapper mw-100">
        <div class="card">
            <div class="card-datatable table-responsive pt-2 pb-2">
                <div class="row m-0">
                    <div class="col-12 col-md-5 order-1 order-sm-0 mt-1 mt-md-0">
                        <div class="panel panel-primary" id="result_panel">
                            <div class="panel-body">
                                <ul class="list-group"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 order-0 order-sm-1 mt-1 mt-md-0">
                        <div id="addresses_ymap" class="w-100" style="height: 500px"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/components/components-modals.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
            integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
            crossorigin="anonymous"></script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script>
        let filterAddresses = function () {
            $.ajax({
                url: '/addresses/map/filter',
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    fast_date_filter: $('[name="fast_date_filter"]:checked').val(),
                },
                success: function (data) {
                    let filterResult = data;
                    let addressesListObject = $('#addresses_map_section .list-group');
                    addressesListObject.empty();

                    Object.entries(filterResult.sentAddresses).forEach(([key, query]) => {
                        let WAContent = "<i onclick='sendAddress(\"" + query.address + "\")' class='fab fa-whatsapp'></i>";
                        addressesListObject.append('<li class="list-group-item d-flex align-items-center">' + WAContent + '<span class="map-point" data-lat="' + query.address_points.custom_latitude + '" data-long="' + query.address_points.custom_longitude + '">' + query.address + '</span></li>');
                    })

                    ymaps.ready(function () {
                        let addressesMapObject = new ymaps.Map("addresses_ymap", {
                            center: [55.76, 37.64],
                            zoom: 9,
                            controls: []
                        }, {
                            searchControlProvider: 'yandex#search',
                            suppressMapOpenBlock: true,
                            suppressObsoleteBrowserNotifier: true,
                        });

                        addressesMapObject.controls.add(new ymaps.control.FullscreenControl());
                        addressesMapObject.controls.add(new ymaps.control.ZoomControl({
                            options: {
                                size: "small"
                            }
                        }));

                        if (filterResult.sentAddresses !== null) {
                            addressesMapObject.setCenter([55.76, 37.64], 9);
                            addressesMapObject.geoObjects.removeAll()
                            Object.entries(filterResult.sentAddresses).forEach(([key, query]) => {
                                if (query.address_points.custom_latitude !== null && query.address_points.custom_longitude !== null) {
                                    addressesMapObject.geoObjects.add(new ymaps.Placemark([query.address_points.custom_latitude, query.address_points.custom_longitude], {
                                        balloonContent: query.address
                                    }));
                                }
                            })
                        }
                    });
                }
            })
        };

        let sendAddress = function (address) {
            Swal.fire({
                title: '<p style="color: #ffffff;font-size: 23px;">Отправить адрес?</p>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Отправить!',
                cancelButtonText: 'Отмена',
                background: 'rgba(0,0,0,0.6)',
                iconColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(address);
                    // $('[data-id="' + queryId + '"]').closest('tr').remove();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: window.location.origin + '/addresses/map/sendAddressToWA',
                        data: {
                            'address': address,
                        },
                        success: function (data) {
                            AlertNotification.alertSuccess(data.alertMessage);
                        },
                        error: function (e) {
                            console.log('Error!', e.message);
                        }
                    });
                }
            })
        }

        filterAddresses();
        $('[name=fast_date_filter]').change(filterAddresses);

        $(document).on('click', '.map-point', function () {
            console.log($(this).data('lat'), $(this).data('long'));
            if ($(this).data('lat') !== null && $(this).data('long') !== null) {
                addressesMapObject.setCenter([$(this).data('lat'), $(this).data('long')], 15);
            }
        })
    </script>
@endsection