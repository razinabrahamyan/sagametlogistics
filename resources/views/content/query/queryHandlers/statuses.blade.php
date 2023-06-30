<div class="col-12 row query-status-picker-wrapper m-0 p-0">
    @canany('showManager','showLogist')
        <div class="col-12 col-lg-4 col-md-6 col-sm-12 p-1">
            <div class="col-12 d-flex justify-content-between flex-md-row flex-column invoice-spacing p-0 m-0">
                <div class="status-change-wrapper bs-stepper row  p-2">
                    <div class="col-12 p-0">
                        <h4>Статус заявки</h4>
                    </div>
                    <div class="form-group">
                        <select class="query-status-picker"
                                onchange="QueryHandler.queryStatusPicker(this);QueryHandler.changeStatus(this, {{$query->id}});">
                            <option value="{{$query->currentStatus->id}}"
                                    style="background: {{$query->currentStatus->color}}; color:#ffffff;">
                                {{$query->currentStatus->title}}
                            </option>
                            @foreach($statuses as $status)
                                @if($query->currentStatus->id != $status->id)
                                    <option value="{{$status->id}}"
                                            @if($query->status == $status->id) selected @endif
                                            style="background: {{$status->color}}; color:#ffffff;">
                                        {{$status->title}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endcanany
    @can('showLogist')
        <div class="col-12 col-lg-4 col-md-6 col-sm-12 p-1 pl-lg-2">
            <div class="col-12 d-flex justify-content-between flex-md-row flex-column invoice-spacing p-0 m-0">
                <div class="status-change-wrapper bs-stepper row  p-2">
                    <div class="col-12 p-0">
                        <h4>Отправка</h4>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success"
                                onclick="SweetAlert.sendToWhatsApp({{$query->id}})">
                            Отправить на WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.query-status-picker').selectpicker();
        $('.query-status-picker-wrapper button[data-toggle="dropdown"]').css({
            "background": "{{$query->currentStatus->color}}",
            "color": "#ffffff",
        });
    });
</script>