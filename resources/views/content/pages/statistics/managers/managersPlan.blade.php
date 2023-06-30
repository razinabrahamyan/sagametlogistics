@extends('layouts.core')
@section('title', 'План менеджеров')

@section('content')
    <div class="container nopadding">
        <section id="analytics-card">
            <div class="row">
                <div class="col-4 col-md-2">
                    <div class="form-group">
                        <label>Год</label>
                        <select class="form-control form-control-sm" v-model="filter.year">
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-group">
                        <label>Месяц</label>
                        <select class="form-control form-control-sm" v-model="filter.month">
                            <option value="1">Январь</option>
                            <option value="2">Февраль</option>
                            <option value="3">Март</option>
                            <option value="4">Апрель</option>
                            <option value="5">Май</option>
                            <option value="6">Июнь</option>
                            <option value="7">Июль</option>
                            <option value="8">Август</option>
                            <option value="9">Сентябрь</option>
                            <option value="10">Октябрь</option>
                            <option value="11">Ноябрь</option>
                            <option value="12">Декабрь</option>
                        </select>
                    </div>
                </div>
                <div class="col-4 col-md-2">
                    <div class="form-group">
                        <label>Настройки</label>
                        <button class="form-control form-control-sm btn btn-sm btn-primary"
                                @click="settingsModal">
                            Настройки
                        </button>
                    </div>
                </div>
            </div>
            <hr class="border-warning mt-0"/>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-1">
                        <div class="card-header">
                            <h4 class="card-title">Общая статистика</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li>
                                        <a data-action="collapse">
                                            <i class="text-primary" data-feather="chevron-down"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row avg-sessions">
                                            <div class="col-md-6 mb-1 d-flex align-items-center">
                                                <i data-feather='clipboard' class="font-medium-1 text-info"></i>
                                                <span class="font-small-4 font-weight-bold ml-75">Всего заявок - @{{ totalStatistic.count }}</span>
                                            </div>
                                            <div class="col-md-6 mb-1 d-flex align-items-center">
                                                <i data-feather='truck' class="font-medium-1 text-success"></i>
                                                <span class="font-small-4 font-weight-bold ml-75">Отправленные заявки - @{{ totalStatistic.sent }}</span>
                                            </div>
                                            <div class="col-md-6 mb-1 mb-md-0 d-flex align-items-center">
                                                <i data-feather='user-check' class="font-medium-1 text-success"></i>
                                                <span class="font-small-4 font-weight-bold ml-75">Постоянные клиенты - @{{ totalStatistic.regularClients }}</span>
                                            </div>
                                            <div class="col-md-6 mb-1 mb-md-0 d-flex align-items-center">
                                                <i data-feather="trash-2" class="font-medium-1 text-danger"></i>
                                                <span class="font-small-4 font-weight-bold ml-75">Удаленные заявки - @{{ totalStatistic.deleted }}</span>
                                            </div>
                                        </div>
                                        <hr class="border-primary mb-0 mt-0 mt-md-1"/>
                                        <div class="row avg-sessions pt-50">
                                            <div class="col-12 col-md-6 mb-1">
                                                <p class="mb-50 font-small-4 font-weight-bolder">
                                                    План звонков:
                                                    @{{ totalStatistic.outgoing_calls_plan + totalStatistic.incoming_calls_plan }}/@{{ totalStatistic.all_calls }}
                                                    (@{{ totalStatistic.all_calls_plan_percent }}%)
                                                </p>
                                                <div class="progress progress-bar-info progress-bar-striped">
                                                    <div class="progress-bar font-weight-bolder" role="progressbar"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         :style="{width:  totalStatistic.all_calls_plan_percent + '%'}"
                                                         v-text=" totalStatistic.all_calls_plan_percent + '%'">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-1">
                                                <p class="mb-50 font-small-4 font-weight-bolder">
                                                    План исх. звонков: @{{ totalStatistic.outgoing_calls_plan }}/@{{
                                                    totalStatistic.outgoing_calls }}
                                                    (@{{ totalStatistic.outgoing_calls_plan_percent }}%)
                                                </p>
                                                <div class="progress progress-bar-success progress-bar-striped">
                                                    <div class="progress-bar font-weight-bolder" role="progressbar"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         :style="{width: totalStatistic.outgoing_calls_plan_percent + '%'}">
                                                        @{{ totalStatistic.outgoing_calls_plan_percent }}%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <p class="mb-50 font-small-4 font-weight-bolder">
                                                    План вход. звонков: @{{ totalStatistic.incoming_calls_plan }}/@{{
                                                    totalStatistic.incoming_calls }}
                                                    (@{{ totalStatistic.incoming_calls_plan_percent }}%)
                                                </p>
                                                <div class="progress progress-bar-warning progress-bar-striped">
                                                    <div class="progress-bar font-weight-bolder" role="progressbar"
                                                         aria-valuemin="0" aria-valuemax="100"
                                                         :style="{width: totalStatistic.incoming_calls_plan_percent+'%'}">
                                                        @{{ totalStatistic.incoming_calls_plan_percent }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-warning mt-0"/>
            <div class="row match-height">
                <div v-for="(manager,index) in managers" class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title" v-text="manager.name"></h4>
                            <span @click="openPlanModal(manager.id,manager.managers_calendar_id)">
                                <i data-feather='settings' class="font-medium-3 text-primary cursor-pointer"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row pb-50">
                                <div class="col-lg-4 col-12">
                                    <div class="form-group mb-1 mb-md-0">
                                        <label for="fact-outgoing-calls">Исходящие звонки</label>
                                        <input id="fact-outgoing-calls" type="number"
                                               v-model="manager.plan.outgoing_calls"
                                               class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="form-group mb-0">
                                        <label for="fact-incoming-calls">Входящие звонки</label>
                                        <input id="fact-incoming-calls" type="number"
                                               v-model="manager.plan.incoming_calls"
                                               class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <div class="form-group mb-0">
                                        <label for="fact-calls"><span class="invisible">Сохранить</span></label>
                                        <button class="form-control form-control-sm btn btn-sm btn-success"
                                                @click="saveManagerPlan(manager.id,manager.managers_calendar_id)">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr class="border-primary"/>
                            <div class="row avg-sessions">
                                <div class="col-md-6 mb-1 d-flex align-items-center">
                                    <i data-feather='clipboard' class="font-medium-1 text-info"></i>
                                    <span class="font-small-4 font-weight-bold ml-75">Всего заявок - @{{ manager.count }}</span>
                                </div>
                                <div class="col-md-6 mb-1 d-flex align-items-center">
                                    <i data-feather='truck' class="font-medium-1 text-success"></i>
                                    <span class="font-small-4 font-weight-bold ml-75">Отправленные заявки - @{{ manager.sent }}</span>
                                </div>
                                <div class="col-md-6 mb-1 mb-md-0 d-flex align-items-center">
                                    <i data-feather='user-check' class="font-medium-1 text-success"></i>
                                    <span class="font-small-4 font-weight-bold ml-75">Постоянные клиенты - @{{ manager.regularClients }}</span>
                                </div>
                                <div class="col-md-6 mb-1 mb-md-0 d-flex align-items-center">
                                    <i data-feather="trash-2" class="font-medium-1 text-danger"></i>
                                    <span class="font-small-4 font-weight-bold ml-75">Удаленные заявки - @{{ manager.deleted }}</span>
                                </div>
                            </div>
                            <hr class="border-primary mb-0 mt-0 mt-md-1"/>
                            <div class="row avg-sessions pt-50">
                                <div class="col-12 col-md-6 mb-1">
                                    <p class="mb-50 font-small-4 font-weight-bolder">
                                        План звонков:
                                        @{{parseInt(manager.plan.outgoing_calls_plan) + parseInt(manager.plan.incoming_calls_plan)}}/@{{parseInt(manager.plan.outgoing_calls)
                                        + parseInt(manager.plan.incoming_calls)}} (@{{
                                        manager.plan.all_calls_plan_percent }}%)
                                    </p>
                                    <div class="progress progress-bar-info progress-bar-striped">
                                        <div class="progress-bar font-weight-bolder" role="progressbar"
                                             aria-valuemin="0" aria-valuemax="100"
                                             :style="{width: manager.plan.all_calls_plan_percent+'%'}"
                                             v-text="manager.plan.all_calls_plan_percent + '%'">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-1">
                                    <p class="mb-50 font-small-4 font-weight-bolder">
                                        План исх. звонков: @{{ manager.plan.outgoing_calls_plan}}/@{{
                                        manager.plan.outgoing_calls }} (@{{ manager.plan.outgoing_calls_plan_percent
                                        }}%)
                                    </p>
                                    <div class="progress progress-bar-success progress-bar-striped">
                                        <div class="progress-bar font-weight-bolder" role="progressbar"
                                             aria-valuemin="0" aria-valuemax="100"
                                             :style="{width: manager.plan.outgoing_calls_plan_percent+'%'}">
                                            @{{ manager.plan.outgoing_calls_plan_percent }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p class="mb-50 font-small-4 font-weight-bolder">
                                        План вход. звонков: @{{ manager.plan.incoming_calls_plan }}/@{{
                                        manager.plan.incoming_calls }} (@{{ manager.plan.incoming_calls_plan_percent
                                        }}%)
                                    </p>
                                    <div class="progress progress-bar-warning progress-bar-striped">
                                        <div class="progress-bar font-weight-bolder" role="progressbar"
                                             aria-valuemin="0" aria-valuemax="100"
                                             :style="{width: manager.plan.incoming_calls_plan_percent+'%'}">
                                            @{{ manager.plan.incoming_calls_plan_percent }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('content.pages.statistics.managers.modals.calendarSettings')
            @include('content.pages.statistics.managers.modals.planFormModal')
        </section>
    </div>
@endsection

@push('vue')
    <script>
        let managersPlan = new Vue({
            el: "#analytics-card",
            data: function () {
                return this.initialState();
            },
            watch: {
                "filter": {
                    handler: function () {
                        this.getManagers();
                    },
                    deep: true,
                },
                "settings.year": function () {
                    this.getSettingsData();
                },
                "settings.month": function () {
                    this.getSettingsData();
                },
            },
            methods: {
                initialState() {
                    return {
                        editablePlanManager: {
                            id: 0,
                            managerCalendarId: 0,
                        },
                        managers: [],
                        filter: {
                            year: new Date().getFullYear(),
                            month: new Date().getMonth() + 1,
                        },
                        settings: {
                            year: new Date().getFullYear(),
                            month: new Date().getMonth() + 1,
                            managers: [],
                        },
                        totalStatistic: {
                            count: 0,
                            sent: 0,
                            deleted: 0,
                            regularClients: 0,
                            all_calls: 0,
                            all_calls_plan: 0,
                            all_calls_plan_percent: 0,
                            outgoing_calls: 0,
                            outgoing_calls_plan: 0,
                            outgoing_calls_plan_percent: 0,
                            incoming_calls: 0,
                            incoming_calls_plan: 0,
                            incoming_calls_plan_percent: 0,
                        },
                    }
                },
                select2Events: function () {
                    $('.select2').each(function () {
                        $(this).select2({
                            theme: "bootstrap"
                        });
                    });

                    $(document).on('change', '#managers_ids', function () {
                        managersPlan.settings.managers = $(this).val();
                    })
                },
                getManagers: function () {
                    axios.post('{{route('axios.statistics.getManagersData')}}', {
                        year: this.filter.year,
                        month: this.filter.month,
                    }, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        this.managers = response.data.managers;
                        this.calculateTotalStatistic();
                    }).catch(e => {
                        console.log(e);
                    });
                },
                getSettingsData: function (year = this.settings.year, month = this.settings.month) {
                    axios.post('{{route('axios.statistics.getSettingsData')}}', {
                        year: year,
                        month: month,
                    }, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        managersPlan.settings.managers = response.data.managers;
                        $('#managers_ids').val(managersPlan.settings.managers).trigger('change');
                    }).catch(e => {
                        console.log(e);
                    });
                },
                updateCalendarSettings: function () {
                    Swal.fire({
                        title: '<p style="color: #ffffff;font-size: 23px;">Сохранить настройки?</p>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Сохранить!',
                        cancelButtonText: 'Отмена',
                        background: 'rgba(0,0,0,0.6)',
                        iconColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('{{route('axios.statistics.updateCalendarSettings')}}', {
                                year: managersPlan.settings.year,
                                month: managersPlan.settings.month,
                                managers: managersPlan.settings.managers,
                            }, {
                                headers: {
                                    Accept: 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            }).then(response => {
                                Swal.fire({
                                    title: 'Успешно!',
                                    icon: 'success',
                                    background: 'rgba(0,0,0,0.6)'
                                });
                                if (managersPlan.settings.year === managersPlan.filter.year && managersPlan.settings.month === managersPlan.filter.month) {
                                    managersPlan.getManagers()
                                }
                            }).catch(e => {
                                console.log(e);
                            });
                        }
                    });

                },
                settingsModal: function () {
                    this.getSettingsData();
                    $('#calendar-settings').modal();
                },
                openPlanModal: function (id, managerCalendarId) {
                    managersPlan.editablePlanManager.id = id;
                    managersPlan.editablePlanManager.managerCalendarId = managerCalendarId;
                    $('#plan-modal').modal();
                },
                saveManagerPlan: function (id, managerCalendarId) {
                    console.log(managersPlan.managers[id].plan)
                    axios.post('{{route('axios.statistics.saveManagerPlan')}}', {
                        plan: managersPlan.managers[id].plan,
                        manager_id: id,
                        managers_calendar_id: managerCalendarId,
                    }, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        Swal.fire({
                            title: 'Успешно!',
                            icon: 'success',
                            background: 'rgba(0,0,0,0.6)'
                        });

                        let incomingCalls = parseInt(managersPlan.managers[id].plan.incoming_calls) ?? 0,
                            outgoingCalls = parseInt(managersPlan.managers[id].plan.outgoing_calls) ?? 0,
                            incomingCallsPlan = parseInt(managersPlan.managers[id].plan.incoming_calls_plan) ?? 0,
                            outgoingCallsPlan = parseInt(managersPlan.managers[id].plan.outgoing_calls_plan) ?? 0,
                            allCalls = outgoingCalls + incomingCalls,
                            allCallsPlan = incomingCallsPlan + outgoingCallsPlan;

                        managersPlan.managers[id].plan.all_calls_plan_percent = (allCalls > 0) ? Math.floor(allCalls / allCallsPlan * 100) : 0;
                        managersPlan.managers[id].plan.outgoing_calls_plan_percent = (outgoingCallsPlan > 0) ? Math.floor(outgoingCalls / outgoingCallsPlan * 100) : 0;
                        managersPlan.managers[id].plan.incoming_calls_plan_percent = (incomingCallsPlan > 0) ? Math.floor(incomingCalls / incomingCallsPlan * 100) : 0;

                        this.calculateTotalStatistic();
                    }).catch(e => {
                        console.log(e);
                    });
                },
                calculateTotalStatistic: function () {
                    managersPlan.totalStatistic = managersPlan.initialState().totalStatistic;
                    let managers = Object.values(managersPlan.managers);

                    if (managers.length) {
                        managers.map(function (manager) {
                            managersPlan.totalStatistic.count += parseInt(manager.count);
                            managersPlan.totalStatistic.sent += parseInt(manager.sent);
                            managersPlan.totalStatistic.deleted += parseInt(manager.deleted);
                            managersPlan.totalStatistic.regularClients += parseInt(manager.regularClients);

                            managersPlan.totalStatistic.outgoing_calls += parseInt(manager.plan.outgoing_calls);
                            managersPlan.totalStatistic.outgoing_calls_plan += parseInt(manager.plan.outgoing_calls_plan);

                            managersPlan.totalStatistic.incoming_calls += parseInt(manager.plan.incoming_calls);
                            managersPlan.totalStatistic.incoming_calls_plan += parseInt(manager.plan.incoming_calls_plan);

                            managersPlan.totalStatistic.all_calls_plan += (parseInt(manager.plan.outgoing_calls_plan) + parseInt(manager.plan.incoming_calls_plan));
                            managersPlan.totalStatistic.all_calls += (parseInt(manager.plan.outgoing_calls) + parseInt(manager.plan.incoming_calls));
                        });

                        managersPlan.totalStatistic.all_calls_plan_percent = (managersPlan.totalStatistic.all_calls_plan > 0) ? Math.floor(managersPlan.totalStatistic.all_calls / managersPlan.totalStatistic.all_calls_plan * 100) : 0;
                        managersPlan.totalStatistic.outgoing_calls_plan_percent = (managersPlan.totalStatistic.outgoing_calls_plan > 0) ? Math.floor(managersPlan.totalStatistic.outgoing_calls / managersPlan.totalStatistic.outgoing_calls_plan * 100) : 0;
                        managersPlan.totalStatistic.incoming_calls_plan_percent = (managersPlan.totalStatistic.incoming_calls_plan > 0) ? Math.floor(managersPlan.totalStatistic.incoming_calls / managersPlan.totalStatistic.incoming_calls_plan * 100) : 0;
                    }
                }
            },
            mounted() {
                this.select2Events();
                this.getManagers();
            },
            created() {
                featherSVG(14)
            }
        });
    </script>
@endpush

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
          integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        .send-svg {
            padding-top: 4px;
            padding-right: 1px;
        }

        .select2-results__option[aria-selected] {
            font-size: 11px;
            font-weight: bold;
        }

        .is-invalid .select2-container .select2-selection {
            border-color: rgb(185, 74, 72) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered, input {
            font-weight: bold !important;
            font-size: 14px !important;
        }
    </style>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{asset('/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection
