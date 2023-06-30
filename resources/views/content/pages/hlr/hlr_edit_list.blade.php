@extends('layouts.core')
@section('title', 'Добро пожаловать')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <style>
        .phone-input-block {
            max-width: 230px !important;
        }
    </style>
@endsection
@section('page-style')
    <link rel="stylesheet" href="{{asset('css/base/pages/app-invoice-list.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"
          integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">

@endsection

@section('content')
    <section id="phone-hlr-section" class="invoice-list-wrapper mw-100">
        <div class="p-0 mb-2" style="max-width: 500px;">
            <form action="" method="POST" enctype="multipart/form-data" class="needs-validation col-12 nopadding">
                @csrf
                <div class="form-group row">
                    <div class="col-6">
                        <input type="text" id="phone" class="form-control addQMask" name="phone" v-model="newPhone"
                               placeholder="+7(___)___-__-__" required>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary form-control" @click="saveNewPhone()"
                                id="checkPhones">
                            Добавить номер
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <table id="phones_table" class="invoice-list-table table table-bordered m-0">
            <thead>
            <tr>
                <th>Номер</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(phone,index) in phones">
                <td class="form-group">
                    <input type="text" class="form-control phone-input-block addQMask" v-model="phones[index].phone"/>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-success"
                            id="checkPhones" @click="editPhone(index)">
                        Сохранить
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" @click="deletePhone(index)" id="checkPhones">
                        Удалить
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
@endsection

@push('vue')
    <script>
        let hlrVue = new Vue({
            el: "#phone-hlr-section",
            data: function () {
                return this.initialState();
            },
            methods: {
                initialState() {
                    return {
                        newPhone: '',
                        phones: JSON.parse(@json($phones)),
                    }
                },
                editPhone(index) {
                    axios.post('/axios/hlr/phone/edit', {
                        'id': this.phones[index].id,
                        'phone': this.phones[index].phone,
                    }, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        AlertNotification.alertSuccess(response.data.message);
                    }).catch(e => {
                        AlertNotification.alertSuccess('Не удалось сохранить');
                        console.log('Error!', e.message);
                    });
                },
                saveNewPhone() {
                    axios.post('/axios/hlr/phone/store', {
                        'phone': this.newPhone,
                    }, {
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }).then(response => {
                        AlertNotification.alertSuccess(response.data.message);
                        this.phones = JSON.parse(response.data.phones);
                    }).catch(e => {
                        AlertNotification.alertSuccess('Не удалось добавить');
                        console.log('Error!', e.message);
                    });
                },
                deletePhone(index) {
                    Swal.fire({
                        title: '<p style="color: #ffffff;font-size: 23px;">Удалить номер?</p>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Да!',
                        cancelButtonText: 'Отмена',
                        background: 'rgba(0,0,0,0.6)',
                        iconColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post('/axios/hlr/phone/destroy', {
                                'id': this.phones[index].id,
                            }, {
                                headers: {
                                    Accept: 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }
                            }).then(response => {
                                AlertNotification.alertSuccess(response.data.message);
                                this.phones = JSON.parse(response.data.phones);
                            }).catch(e => {
                                AlertNotification.alertSuccess('Не удалось удалить');
                                console.log('Error!', e.message);
                            });
                        }
                    });
                },
            },
        });
    </script>
@endpush

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