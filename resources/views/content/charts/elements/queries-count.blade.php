<div id="managerStat" class="col-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-warning">
                        Расширенный фильтр
                    </h4>
                    <div class="heading-elements text-warning">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="col-12 row m-0 p-0">
                            <div class="col-md-2 mb-1 p-0">
                                <label>Дата создания от</label>
                                <input type="text" name="start_date"
                                       class="form-control form-control-sm flatpickr-basic w-100"
                                       placeholder="Указать" v-model="filter.startDate"/>
                            </div>
                            <div class="col-md-2 mb-1 p-0 pl-md-1">
                                <label>Дата создания до</label>
                                <input type="text" name="end_date"
                                       class="form-control form-control-sm flatpickr-basic w-100"
                                       placeholder="Указать" v-model="filter.endDate"/>
                            </div>
                        </div>
                        <div class="col-12 row m-0 p-0">
                            <div class="col-md-2 mb-1 p-0 select2-sm">
                                <label>Менеджеры</label>
                                <select id="manager_ids" class="select2 form-control form-control-sm" multiple>
                                    <option v-for="manager in managers" :value="manager.id" v-text="manager.name">
                                </select>
                            </div>
                            <div class="col-md-2 mb-1 p-0 pl-md-1">
                                <label>Тип металла</label>
                                <select id="metalType" class="form-control form-control-sm" v-model="filter.metalType">
                                    <option value="">Все</option>
                                    <option v-for="metalType in metalTypes" :value="metalType.id"
                                            v-text="metalType.title">
                                </select>
                            </div>
                        </div>
                        <div class="col-12 row m-0 p-0">
                            <div class="col-md-4 mb-1 p-0">
                                <button class="btn btn-primary w-100" @click="resetFilter">Сброс</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 m-0">
            <hr class="border-warning">
            <h2 class="text-center mb-1">
                Общая статистика
            </h2>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="font-weight-bolder mb-0" v-text="sum"></h2>
                        <p class="card-text text-warning font-weight-bold">Заявок за период</p>
                    </div>
                    <div class="avatar bg-light-primary p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather='calendar' class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="font-weight-bolder mb-0" v-text="sentSum"></h2>
                        <p class="card-text text-warning font-weight-bold">Отправлено</p>
                    </div>
                    <div class="avatar bg-light-success p-50 m-0">
                        <div class="avatar-content send-svg">
                            <i data-feather='send' class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="font-weight-bolder mb-0" v-text="deleteSum"></h2>
                        <p class="card-text text-warning font-weight-bold">Удалено</p>
                    </div>
                    <div class="avatar bg-light-danger p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather='trash-2' class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h2 class="font-weight-bolder mb-0" v-text="metalAVGprice + ' ₽'"></h2>
                        <p class="card-text text-warning font-weight-bold">
                            Средняя цена <span class="font-small-1">(с 04.05.22)</span>
                        </p>
                    </div>
                    <div class="avatar bg-light-info p-50 m-0">
                        <div class="avatar-content">
                            <i data-feather='dollar-sign' class="font-medium-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 m-0">
            <hr class="border-warning">
            <h2 class="text-center mb-1">
                Статистика менеджеров
            </h2>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold">
                        Создано
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="created-manager-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold">
                        Отправлено
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="sent-manager-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold">
                        Удалено
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="deleted-manager-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold">
                        Постоянные клиенты
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="regular-client-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-12 m-0">
            <hr class="border-warning">
            <h2 class="text-center mb-1">
                Статистика цен и металлов
            </h2>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold text-center">
                        Среднее предложение<br><span class="font-small-1">(с 04.05.22)</span>
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="price-avg-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold text-center">
                        Минимальный предполагаемый вес<br><span class="font-small-1">(с 04.05.22)</span>
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="weight-from-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-end pb-0">
                    <h6 class="m-auto text-warning font-weight-bold text-center">
                        Максимальный предполагаемый вес<br><span class="font-small-1">(с 04.05.22)</span>
                    </h6>
                </div>
                <div class="card-body p-1">
                    <div id="weight-to-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-12 m-0">
            <hr class="border-warning">
        </div>
    </div>
</div>
@push('vue')
    <script>
        let statisticVue = new Vue({
            el: "#managerStat",
            data: function () {
                return this.initialState();
            },
            watch: {
                'filter': {
                    handler: function () {
                        console.log(1)
                        this.getStatistic();
                        statisticVue.updateCharts();
                    },
                    deep: true,
                }
            },
            methods: {
                initialState() {
                    return {
                        managers: @json($managers),
                        metalTypes: @json($metalTypes),
                        sum: 0,
                        sentSum: 0,
                        deleteSum: 0,
                        metalAVGprice: 0,
                        filter: {
                            startDate: "",
                            endDate: "",
                            manager_ids: [],
                            metalType: 1,
                        },
                        chartsObjects: {
                            createdChart: null,
                            sentChart: null,
                            deletedChart: null,
                            regularClientChart: null,
                            priceAvgChart: null,
                            weightFromChart: null,
                            weightToChart: null,
                        },
                    }
                },
                updateCharts: function () {
                    let weightFromChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' т.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Вес от',
                                        }
                                    }
                                }
                            }
                        },
                    };
                    let weightToChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' т.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Вес до',
                                        }
                                    }
                                }
                            }
                        },
                    };
                    let priceAvgChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' ₽';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Среднее',
                                            formatter: function (value) {
                                                let total = 0, count = 0;
                                                value.config.series.map(function (series) {
                                                    series = parseInt(series)
                                                    if (series > 0) {
                                                        total += series;
                                                        count++;
                                                    }
                                                });

                                                return Math.floor(total / count)+' ₽';
                                            }
                                        }
                                    }
                                }
                            }
                        },
                    };
                    let createdManagerChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' шт.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Создано',
                                        }
                                    }
                                }
                            }
                        },
                    };
                    let sentChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' шт.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Отправлено',
                                        }
                                    }
                                }
                            }
                        },
                    };
                    let deletedManagerChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false,
                            },
                            series: {
                                value: {
                                    formatter: function (value) {
                                        return "$" + parseFloat(value).toLocaleString();
                                    }
                                },
                            },
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' шт.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Удалено',
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => {
                                                    return a + b
                                                }, 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                            }
                                        }
                                    }
                                }
                            }
                        },
                    };
                    let regularClientsChartOptions = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false,
                            },
                            series: {
                                value: {
                                    formatter: function (value) {
                                        return "$" + parseFloat(value).toLocaleString();
                                    }
                                },
                            },
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' шт.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Постоянные',
                                        }
                                    }
                                }
                            }
                        },
                    };
                    
                    if (statisticVue.statistic.managers) {
                        Object.entries(statisticVue.statistic.managers).map(function (array) {
                            weightFromChartOptions.series.push(array[1].weight_from);
                            weightFromChartOptions.labels.push(array[1].manager_name);

                            weightToChartOptions.series.push(array[1].weight_to);
                            weightToChartOptions.labels.push(array[1].manager_name);

                            priceAvgChartOptions.series.push(array[1].metal_avg_price);
                            priceAvgChartOptions.labels.push(array[1].manager_name);
                            
                            createdManagerChartOptions.series.push(array[1].created_queries);
                            createdManagerChartOptions.labels.push(array[1].manager_name);
                            
                            sentChartOptions.series.push(array[1].sent_queries);
                            sentChartOptions.labels.push(array[1].manager_name);
                            
                            deletedManagerChartOptions.series.push(array[1].deleted_queries);
                            deletedManagerChartOptions.labels.push(array[1].manager_name);
                            
                            regularClientsChartOptions.series.push(array[1].regular_clients_queries);
                            regularClientsChartOptions.labels.push(array[1].manager_name);
                        })
                    }

                    this.chartsObjects.weightFromChart.updateOptions(weightFromChartOptions);
                    this.chartsObjects.weightToChart.updateOptions(weightFromChartOptions);
                    this.chartsObjects.priceAvgChart.updateOptions(priceAvgChartOptions);
                    this.chartsObjects.createdChart.updateOptions(createdManagerChartOptions);
                    this.chartsObjects.sentChart.updateOptions(sentChartOptions);
                    this.chartsObjects.deletedChart.updateOptions(deletedManagerChartOptions);
                    this.chartsObjects.regularClientChart.updateOptions(regularClientsChartOptions);
                },
                charts: function () {
                    let options = {
                        chart: {
                            type: 'donut',
                            height: 250,
                            toolbar: {
                                show: true
                            },
                            labels: {
                                show: false
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        series: [],
                        legend: {show: false},
                        comparedResult: [],
                        labels: [],
                        stroke: {width: 0},
                        colors: [
                            window.colors.solid.primary, window.colors.solid.warning,
                            window.colors.solid.danger, window.colors.solid.success, window.colors.solid.info,
                            window.colors.solid.secondary, '#00008B', '#800000'
                        ],
                        plotOptions: {
                            pie: {
                                startAngle: -10,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            offsetY: 15
                                        },
                                        value: {
                                            offsetY: -25,
                                            formatter: function (val) {
                                                return parseInt(val) + ' шт.';
                                            }
                                        },
                                        total: {
                                            show: true,
                                            offsetY: 15,
                                            label: 'Создано',
                                        }
                                    }
                                }
                            }
                        },
                    };

                    let $weightFromChart = document.querySelector('#weight-from-chart');
                    this.chartsObjects.weightFromChart = new ApexCharts($weightFromChart, options);
                    this.chartsObjects.weightFromChart.render();

                    let $weightToChart = document.querySelector('#weight-to-chart');
                    this.chartsObjects.weightToChart = new ApexCharts($weightToChart, options);
                    this.chartsObjects.weightToChart.render();

                    let $createdManagaerChart = document.querySelector('#created-manager-chart');
                    this.chartsObjects.createdChart = new ApexCharts($createdManagaerChart, options);
                    this.chartsObjects.createdChart.render();

                    let $sentChart = document.querySelector('#sent-manager-chart');
                    this.chartsObjects.sentChart = new ApexCharts($sentChart, options);
                    this.chartsObjects.sentChart.render();

                    let $deletedManagaerChart = document.querySelector('#deleted-manager-chart');
                    this.chartsObjects.deletedChart = new ApexCharts($deletedManagaerChart, options);
                    this.chartsObjects.deletedChart.render();

                    let $regularClientsChart = document.querySelector('#regular-client-chart');
                    this.chartsObjects.regularClientChart = new ApexCharts($regularClientsChart, options);
                    this.chartsObjects.regularClientChart.render();

                    let $metalPriceAVGChart = document.querySelector('#price-avg-chart');
                    this.chartsObjects.priceAvgChart = new ApexCharts($metalPriceAVGChart, options);
                    this.chartsObjects.priceAvgChart.render();
                },
                getStatistic: function () {
                    axios.post('{{route('axios.statistics.get')}}', {
                        start_date: this.filter.startDate,
                        end_date: this.filter.endDate,
                        manager_ids: this.filter.manager_ids,
                        metal_type: this.filter.metalType,
                    }, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        statisticVue.statistic = response.data;
                        statisticVue.sum = response.data.totals.totalCount;
                        statisticVue.sentSum = response.data.totals.sent;
                        statisticVue.deleteSum = response.data.totals.deleted;
                        statisticVue.metalAVGprice = response.data.totals.metalAVGprice;
                        statisticVue.updateCharts();
                    }).catch(e => {
                        console.log(e);
                    });
                },
                destroyDataTable: function () {
                    $('#manager_stat_table').DataTable().destroy();
                },
                initDataTable: function () {
                    $('#manager_stat_table').DataTable({
                        serverSide: true,
                        processing: true,
                        ajax: {
                            url: window.location.origin + "/axios/statistics/managerStat",
                            method: "get",
                            data: {
                                start_date: this.filter.startDate,
                                end_date: this.filter.endDate,
                            }
                        },
                        drawCallback: function (settings) {
                            statisticVue.sum = statisticVue.sentSum = statisticVue.deleteSum = statisticVue.metalAVGprice = 0
                            if (settings.json.data.length) {
                                settings.json.data.forEach(function (item, index) {
                                    statisticVue.sum += item[1];
                                    statisticVue.sentSum += item[2];
                                    statisticVue.deleteSum += item[3];
                                });
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
                        ],
                        stateSave: true,
                        bStateSave: true,
                        lengthChange: true,
                        searching: false,
                        responsive: true,
                        paging: true,
                        select: true,
                        ordering: false,
                        info: false,
                        language: {
                            paginate: {
                                next: " ",
                                previous: " "
                            },
                            zeroRecords: "Заявок не найдено",
                            emptyTable: "Заявок не найдено",
                            lengthMenu: "Показать _MENU_ заявок",
                            search: "Поиск:",
                            processing: "Идет загрузка заявок...",
                            info: "Показано с _START_ по _END_ из _TOTAL_ заявок",
                        },
                    });
                },
                updateDataTable: function () {
                    this.destroyDataTable();
                    this.initDataTable();
                },
                select2Init(params) {
                    $('.select2').each(function () {
                        let $this = $(this);

                        $this.wrap('<div class="position-relative"></div>');
                        $this.select2(params);
                    });
                    $(document).on('change', '#manager_ids', function () {
                        statisticVue.filter.manager_ids = $(this).val();
                    });
                },
                resetFilter: function () {
                    statisticVue.filter = statisticVue.initialState().filter;
                    $('#manager_ids').val('[]').trigger('change')
                },
            },
            mounted() {
                this.getStatistic();
                this.charts();
                this.select2Init({
                    theme: "bootstrap",
                    overflow: "scroll",
                    placeholder: "Выбрать"
                });

                $('.flatpickr-basic').flatpickr();
            }
        });
    </script>
@endpush