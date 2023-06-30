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
    <div id="recovery-list-wrapper" class="app-content content p-0 m-0">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="row m-0 mt-2">
                                    <label class="col-12">Фильтрация по дате вывоза</label>
                                    <div class="col-12 mb-1">
                                        <div id="departure_date_filter" class="btn-group btn-group-toggle"
                                             data-toggle="buttons">
                                            <label v-for="(fastDateFilterValue,index) in fastDateFilterValues"
                                                   :class="['btn btn-outline-primary dep_day_lable', (fastDateFilterValue.value === filter.fastDateFilter) ? 'active' : '']">
                                                <input type="radio" name="fast_date_filter"
                                                       :id="'fastDate-' + index"
                                                       :value="fastDateFilterValue.value"
                                                       v-model="filter.fastDateFilter"/>
                                                <span v-text="fastDateFilterValue.name"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <label class="col-12">Фильтрация по дате создания</label>
                                    <div class="mb-1 ml-1">
                                        <input type="text" name="start_date" id="start_date"
                                               class="form-control flatpickr-basic"
                                               placeholder="Дата от" v-model="filter.startDate"/>
                                    </div>
                                    <div class="mb-1 ml-1">
                                        <input type="text" name="end_date" id="end_date"
                                               class="form-control flatpickr-basic"
                                               placeholder="Дата до" v-model="filter.endDate"/>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <button class="btn btn-primary" @click="dropFilter()">
                                            Сброс фильтра
                                        </button>
                                    </div>
                                </div>
                                <hr class="m-0"/>
                                <table id="recovery_list_table" class="invoice-list-table table">
                                    <thead>
                                    <tr>
                                        {{--ID--}}
                                        <th class="text-center">
                                            #
                                        </th>
                                        {{--ID--}}
                                        {{--Типы машины--}}
                                        <th class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" stroke-width="2" class="feather feather-truck"
                                                 viewBox="0 0 24 24">
                                                <defs/>
                                                <path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/>
                                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                                <circle cx="18.5" cy="18.5" r="2.5"/>
                                            </svg>
                                        </th>
                                        {{--Типы машины--}}
                                        {{--Время выезда--}}
                                        <th class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" stroke-width="2" class="feather feather-clock"
                                                 viewBox="0 0 24 24">
                                                <defs/>
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="M12 6v6l4 2"/>
                                            </svg>
                                        </th>
                                        {{--Время выезда--}}
                                        {{--Адрес выезда--}}
                                        <th class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 465 465">
                                                <defs/>
                                                <path d="M457.1 218.5l-71-143.2a11 11 0 00-9.4-5.7l-4.7 1h-92a49.1 49.1 0 00-95 0H93l-4.7-1a11 11 0 00-9.4 5.7l-71 143.2a10 10 0 00-7.9 10c0 43.8 39.7 79.8 88.3 79.8s88.8-36 88.8-79.9c0-4.7-3.3-8.7-7.8-10L106 91.6h78.3a48.6 48.6 0 0037.6 37.6v183.4c-34 4.2-60.6 29.8-64.7 56h-23c-6.2.4-11 5.3-11.5 11.4v41.8c.5 5.8 5.6 10 11.4 9.4h196.5a10.4 10.4 0 0011.5-9.4V380c-.5-6.1-5.4-11-11.5-11.5h-23c-4.2-26.1-30.8-51.7-64.8-55.9V129.1a48.6 48.6 0 0037.7-37.6h78.3l-63.2 127a10.5 10.5 0 00-7.8 10c0 43.8 39.7 79.8 88.8 79.8 49.1 0 88.3-36 88.3-79.9a10 10 0 00-7.9-10zM88.3 286.4c-33 0-60.6-22.5-66.4-48.6h133.3c-5.8 26.1-33.5 48.6-66.9 48.6zm57.5-69.5H31.3l57-114.4 57.5 114.4zm175.5 172.4v21H143.7v-21h177.6zm-35-20.9H178.7c4.2-20.9 26.6-36.5 53.8-36.5s49.6 15.6 53.8 36.5zm-53.8-258.6a28.2 28.2 0 110-56.4 28.2 28.2 0 010 56.4zm144.2-7.3l57 114.4H319.1l57.5-114.4zm0 183.9c-33.4 0-61.1-22.5-66.9-48.6H443c-5.7 26.1-33.4 48.6-66.3 48.6z"/>
                                            </svg>
                                        </th>
                                        {{--Адрес выезда--}}
                                        <th class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <defs/>
                                                <path d="M496 224a16 16 0 00-16 16v181.2l-128 51.2V304a16 16 0 00-32 0v168.4l-128-51.2V167.6l74.2 29.7a16 16 0 1011.9-29.7l-95.8-38.4h-.3c-3.8-1.6-8.1-1.6-11.9 0h-.3L10 193.2A16 16 0 000 208v288A16 16 0 0022 510.8l154-61.6 153.8 61.6h.3c3.8 1.6 8 1.6 11.9 0h.3l159.7-64c6-2.4 10-8.2 10-14.8V240a16 16 0 00-16-16zM160 421.2L32 472.4V218.8l128-51.2v253.6zM400 64a48 48 0 10.1 96.1 48 48 0 000-96.1zm0 64a16 16 0 110-32 16 16 0 010 32z"/>
                                                <path d="M400 0c-61.7 0-112 50.2-112 112 0 57.5 89.9 159.3 100.1 170.7a16 16 0 0023.8 0C422.2 271.3 512 169.5 512 112 512 50.2 461.8 0 400 0zm0 247.6c-35-41.5-80-105-80-135.6a80.1 80.1 0 01160 0c0 30.5-45 94.1-80 135.6z"/>
                                            </svg>
                                        </th>
                                        {{--Менеджер--}}
                                        <th class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" stroke-width="2" class="feather feather-user"
                                                 viewBox="0 0 24 24">
                                                <defs/>
                                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </th>
                                        {{--Фото--}}
                                        <th class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" stroke-width="2" class="feather feather-camera"
                                                 viewBox="0 0 24 24">
                                                <defs/>
                                                <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
                                                <circle cx="12" cy="13" r="4"/>
                                            </svg>
                                        </th>
                                        {{--Кнопки--}}
                                        <th class="text-center cell-fit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-linecap="round"
                                                 stroke-linejoin="round" stroke-width="2"
                                                 class="feather feather-sliders"
                                                 viewBox="0 0 24 24">
                                                <defs/>
                                                <path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6"/>
                                            </svg>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
@endsection

@section('vendor-script')
    <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
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
@endsection

@push('vue')
    <script>
        let dataTable = new Vue({
            el: "#recovery-list-wrapper",
            data: function () {
                return this.initialState();
            },
            watch: {
                'filter': {
                    handler: function () {
                        dataTable.updateDataTable();
                    },
                    deep: true,
                }
            },
            methods: {
                initialState() {
                    return {
                        fastDateFilterValues: [
                            {
                                value: 'today',
                                name: 'Сегодня',
                            },
                            {
                                value: 'tomorrow',
                                name: 'Завтра',
                            },
                            {
                                value: '',
                                name: 'Все',
                            }
                        ],
                        filter: {
                            fastDateFilter: "today",
                            startDate: "",
                            endDate: "",
                        }
                    }
                },
                destroyDataTable: function () {
                    $('#recovery_list_table').DataTable().destroy();
                },
                initDataTable: function () {
                    $('#recovery_list_table').DataTable({
                        serverSide: true,
                        processing: true,
                        ajax: {
                            url: "/axios/queries/recovery-query-lazy-load",
                            method: "get",
                            data: {
                                start_date: this.filter.startDate,
                                end_date: this.filter.endDate,
                                fast_date_filter: this.filter.fastDateFilter,
                            }
                        },
                        drawCallback: function (settings) {
                            $('#recovery_list_table .row').eq(0).addClass('d-flex justify-content-between align-items-center m-1');
                            $('#recovery_list_table .row .col-sm-12.col-md-6').removeClass('col-sm-12 col-md-6')
                            setTimeout(function () {
                                $('#recovery_list_table td').addClass('dtr-control');
                            }, 50);
                        },
                        lengthChange: true,
                        responsive: true,
                        paging: true,
                        select: true,
                        orderable: false,
                        info: false,
                        aaSorting: [[0, 'desc']],
                        searchDelay: 500,
                        language: {
                            paginate: {
                                next: " ",
                                previous: " "
                            },
                            zeroRecords: "Ничего не найдено",
                            emptyTable: "Ничего не найдено",
                            lengthMenu: "Показать _MENU_ позиций",
                            search: "Поиск:",
                            processing: "Идет загрузка позиций...",
                            info: "Показано с _START_ по _END_ из _TOTAL_ позиций",
                        },
                        columnDefs: [
                            {
                                "className": "text-center",
                                "targets": "_all",
                            },
                            {
                                'orderable': false,
                                'targets': [7],
                            },
                        ],
                    });
                },
                updateDataTable: function () {
                    this.destroyDataTable();
                    this.initDataTable();
                },
                dropFilter: function () {
                    Object.assign(this.$data, this.initialState());
                    $('[type="search"]').val('');
                    dataTable.updateDataTable();
                },
                recoverQuery: function (id) {
                    Swal.fire({
                        title: 'Восстановить заявку #' + id + ' ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Восстановить!',
                        cancelButtonText: 'Отмена',
                        background: 'rgba(0,0,0,0.6)',
                        iconColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('/axios/queries/recover', {
                                id: id
                            }, {
                                headers: {
                                    Accept: 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            }).then(response => {
                                dataTable.updateDataTable();
                                if (response.status) {
                                    Swal.fire({
                                        title: 'Заявка #'+id+' успешно восстановлена!',
                                        icon: 'success',
                                        background: 'rgba(0,0,0,0.6)'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Не удалось добавить...',
                                        icon: 'error',
                                        background: 'rgba(0,0,0,0.6)'
                                    });
                                }
                            }).catch(e => {
                                console.log(e);
                                Swal.fire({
                                    title: 'Не удалось добавить...',
                                    icon: 'error',
                                    background: 'rgba(0,0,0,0.6)'
                                });
                            });
                        }
                    })
                },
            },
            mounted() {
                this.initDataTable();
                $('.flatpickr-basic').flatpickr();

                /*Jquery Events For Rendered Elements*/
                $(document).on('click', '.recover-btn', function () {
                    dataTable.recoverQuery($(this).data('id'));
                })
                /*Jquery Events For Rendered Elements*/
            }
        });

    </script>
@endpush