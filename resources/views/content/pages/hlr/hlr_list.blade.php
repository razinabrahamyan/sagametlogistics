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
    <section id="phone-hlr-section" class="invoice-list-wrapper mw-100">
        <div class="card">
            <div class="card-datatable table-responsive pt-2 pb-2">
                <div class="col-12">
                    <div class="panel panel-primary" id="result_panel">
                        <div class="panel-body">
                            <div class="col-12 p-0">
                                <a href="{{route('hlr.edit.list')}}" type="button" class="btn btn-primary" id="checkPhones">
                                    Редактирование номеров
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="phone-hlr-section" class="invoice-list-wrapper mw-100">
        <div class="card">
            <div class="card-datatable table-responsive pt-2 pb-2">
                <div class="col-12">
                    <div class="panel panel-primary" id="result_panel">
                        <div class="panel-body">
                            <div class="col-12 p-0 mb-2">
                                <h5>
                                    Баланс: {{$balance}}₽ <a href="https://smsc.ru/" target="_blank">Пополнить</a>
                                </h5>
                                <h5>
                                    Проверок осталось: {{floor($balance/0.4)}}
                                </h5>
                                <h5>
                                    SMS-Ping Проверок осталось: {{floor($balance/2.7)}}
                                </h5>
                            </div>
                            <hr class="border-primary">
                            <div class="col-12 p-0 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="smsPing">
                                    <label class="custom-control-label" for="smsPing">Включить SMS-Ping (Мегафон
                                        - 2.7₽)</label>
                                </div>
                            </div>
                            <div class="col-12 p-0 mb-1">
                                <button onclick="sendHLR()" type="button" class="btn btn-success" id="checkPhones">
                                    Прозвонить номера
                                </button>
                            </div>
                            <hr class="border-primary">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="selectAll"
                                               onclick="clickAllCheckBoxes()">
                                        <label class="custom-control-label" for="selectAll">Выбрать все номера</label>
                                    </div>
                                </li>
                                @foreach($phones as $phone)
                                    <li class="list-group-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="phone-checkbox custom-control-input"
                                                   data-id="{{$phone->id}}" value="{{$phone->phone}}"
                                                   id="check{{$phone->id}}">
                                            <label class="custom-control-label" for="check{{$phone->id}}">
                                                {{$phone->phone}}
                                                <i class="far fa-check-circle text-success d-none"></i>
                                                <i class="fas fa-exclamation-circle text-danger d-none"></i>
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
@endsection

@section('page-script')
    <script>
        function clickAllCheckBoxes() {
            let checkboxs = document.getElementsByTagName("input");
            for (let i = 0; i < checkboxs.length; i++) { //zero-based array
                checkboxs[i].checked = document.getElementById('selectAll').checked;
            }
        }

        let sendHLR = function () {
            Swal.fire({
                title: '<p style="color: #ffffff;font-size: 23px;">Начать прозвон?</p>',
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
                    let phones = [];
                    $(".phone-checkbox[type='checkbox']").each(function () {
                        if (this.checked) {
                            phones.push({
                                id: $(this).attr('data-id'),
                                phone: $(this).val(),
                            })
                        }
                    });

                    // $('[data-id="' + queryId + '"]').closest('tr').remove();
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: window.location.origin + '/telephony/sendhlr',
                        data: {
                            'phones': phones,
                            'smsPing': $('#smsPing').is(':checked'),
                        },
                        success: function (data) {
                            let checkedNumbers = data.checkedPhones;

                            if (Object.keys(checkedNumbers).length) {
                                Object.entries(checkedNumbers).forEach(([key, value]) => {
                                    let label = $('label[for="check' + value.id + '"] i');
                                    label.addClass('d-none');
                                    if (value.isAvailable) {
                                        $('label[for="check' + value.id + '"] i.text-success').removeClass('d-none');
                                    } else {
                                        $('label[for="check' + value.id + '"] i.text-danger').removeClass('d-none');
                                    }
                                });
                            }
                            AlertNotification.alertSuccess(data.alertMessage);
                        },
                        error: function (e) {
                            console.log('Error!', e.message);
                        }
                    });
                }
            })
        }
    </script>
@endsection