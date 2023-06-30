<section id="drivers-wrapper" class="invoice-list-wrapper mw-100">
    <div class="card">
        <div class="card-datatable table-responsive">
{{--            <div class="container m-0 mt-2">--}}
{{--                <a href="{{route('drivers.create')}}" class="btn btn-primary waves-effect waves-float waves-light">--}}
{{--                    Добавить водителя--}}
{{--                </a>--}}
{{--            </div>--}}
            <table id="drivers_table" class="invoice-list-table table container">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Имя</th>
                    <th class="text-center">Телефон</th>
                    <th class="text-center">Номер машины</th>
                    <th class="text-center">Тип машины</th>
                    <th class="text-center cell-fit">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td class="text-center">{{$driver->id}}</td>
                        <td class="text-center">{{$driver->full_name}}</td>
                        <td class="text-center">
                            <a class="text-decoration-underline" href="tel:{{$driver->phone}}"
                               title="Позвонить" data-toggle-tooltip="tooltip" data-placement="top">
                                <u>{{$driver->phone}}</u>
                            </a>
                        </td>
                        <td class="text-center">{{$driver->car_numbers}}</td>
                        <td class="text-center">{{$driver->machineType->title}}</td>
                        <td class="text-center">
                            @include('content.drivers.elements.actions',['driver',$driver])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@push('vue')
    <script>
        let driversVue = new Vue({
            el: "#drivers-wrapper",
            data: function () {
                return this.initialState();
            },
            methods: {
                initialState() {
                    return {}
                },
                destroyDataTable: function () {
                    $('#drivers_table').DataTable().destroy();
                },
                initDataTable: function () {
                    $('#drivers_table').DataTable({
                        processing: true,
                        lengthChange: true,
                        responsive: true,
                        paging: true,
                        select: true,
                        orderable: true,
                        info: false,
                        aaSorting: [[0, 'asc']],
                        drawCallback: function (settings) {
                            setTimeout(function () {
                                $('#drivers_table td').addClass('dtr-control');
                            }, 50);
                        },
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
                        columnDefs: [
                            {
                                "className": "text-center",
                                "targets": "_all",
                            },
                        ]
                    });
                },
                updateDataTable: function () {
                    this.destroyDataTable();
                    this.initDataTable();
                },
                deleteDriver: function (driverId) {
                    Swal.fire({
                        title: '<p style="color: #ffffff;font-size: 23px;">Удалить водителя?</p>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Удалить!',
                        cancelButtonText: 'Отмена',
                        background: 'rgba(0,0,0,0.6)',
                        iconColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('/axios/drivers/delete', {
                                id: driverId,
                            }, {
                                headers: {
                                    Accept: 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            }).then(response => {
                                Swal.fire({
                                    title: 'Водитель удален!',
                                    icon: 'success',
                                    background: 'rgba(0,0,0,0.6)'
                                });
                                window.location.reload();
                            }).catch(e => {
                                console.log(e);
                                Swal.fire({
                                    title: 'Что то пошло не так...',
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
                $('#drivers_table_wrapper .row').eq(0).addClass('d-flex justify-content-between align-items-center m-1');
            }
        });
    </script>
@endpush