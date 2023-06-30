<div class="col-12">
    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
        <form action="{{route('updateQuery',$query->id)}}" method="POST" enctype="multipart/form-data"
              class="needs-validation col-12 nopadding">
            @csrf
            @method('PUT')
            @cannot('showResponsibleForDrivers')
                @include('content.query.queryWizardForms.query_form_section')
            @endcannot
            @canany(['showLogist','showResponsibleForDrivers'])
                @if(!empty($drivers->drivers_data))
                    <section id="multiple-column-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            Изменение данных водителей для заявки
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        @foreach($drivers->drivers_data as $key=>$driver)
                                            <input type="hidden" name="driversData[{{$driver->driver_id}}][id]"
                                                   value="{{$driver->driver_id}}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="text-success">
                                                        {{$driver->car_number}}
                                                    </span>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-column">Имя водителя</label>
                                                        <input type="text" id="first-name-column" class="form-control"
                                                               placeholder="First Name"
                                                               name="driversData[{{$driver->driver_id}}][name]"
                                                               value="{{$driver->driver_name}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="last-name-column">Телефон</label>
                                                        <input type="text" id="last-name-column" class="form-control"
                                                               placeholder="Last Name"
                                                               name="driversData[{{$driver->driver_id}}][phone]"
                                                               value="{{$driver->phone}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <div class="form-group">
                                                        <label for="last-name-column">Номер машины</label>
                                                        <input type="text" id="last-name-column" class="form-control"
                                                               placeholder="Last Name"
                                                               name="driversData[{{$driver->driver_id}}][car_number]"
                                                               value="{{$driver->car_number}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <label class="form-label" for="car_type">Тип метала</label>
                                                    <select class="select2 w-100" id="car_type_{{$driver->driver_id}}"
                                                            name="driversData[{{$driver->driver_id}}][car_type]">
                                                        @foreach($machines as $machine)
                                                            <option value="{{$machine->title}}"
                                                                    @if($machine->title == $driver->type) selected @endif>
                                                                {{$machine->title}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1">Сохранить</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endcanany
        </form>
    </div>
</div>