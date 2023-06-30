<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Водитель</h4>
                </div>
                <div class="card-body">
                    <form class="form">
                        @if(!empty($driver))
                            <input type="hidden" id="id" name="id" value="{{$driver->id}}">
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="full_name">Ф.И.О.</label>
                                    <input type="text" id="full_name" class="form-control"
                                           placeholder="Введите Ф.И.О."
                                           name="full_name"
                                           @if(!empty($driver)) value="{{$driver->full_name}}" @endif required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Телефон</label>
                                    <input type="text" id="phone" class="form-control" placeholder="Введите телефон"
                                           name="phone" @if(!empty($driver)) value="{{$driver->phone}}"
                                           @endif required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" id="email" class="form-control" placeholder="Введите E-mail"
                                           name="email" @if(!empty($driver)) value="{{$driver->email}}" @endif/>
                                </div>
                            </div>
                            @if(empty($driver))
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="password">Пароль для входа</label>
                                        <input type="text" id="password" class="form-control"
                                               placeholder="Введите пароль для входа" name="password" required/>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="car_numbers">Номера машины</label>
                                    <input type="text" id="car_numbers" class="form-control"
                                           placeholder="Введите номера машины" name="car_numbers"
                                           @if(!empty($driver)) value="{{$driver->car_numbers}}" @endif required/>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="type_id">Укажите тип машины</label>
                                    <select class="form-control select2" id="type_id" name="type_id">
                                        @foreach($machines as $machine)
                                            <option value="{{$machine->id}}"
                                                    @if(!empty($driver) && $machine->id == $driver->machineType->id) selected @endif>
                                                {{$machine->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-submit mr-1">Сохранить</button>
                                <button type="reset" class="btn btn-outline-secondary">Сбросить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>