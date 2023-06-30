<div class="modal modal-slide-in fade" id="calendar-settings">
    <div class="modal-dialog sidebar-sm">
        <form class="add-new-record modal-content pt-0">
            @csrf
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">Настройки</h5>
            </div>
            <div class="modal-body flex-grow-1">
                <div class="form-group">
                    <label>Год</label>
                    <select class="form-control form-control-sm" v-model="settings.year">
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2025</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Месяц</label>
                    <select class="form-control form-control-sm" v-model="settings.month">
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
                <div class="form-group">
                    <label class="form-label" for="basic-icon-default-fullname">
                        Менеджеры
                    </label>
                    <select class="form-control form-control-sm select2" name="managers_ids" id="managers_ids" multiple
                            required>
                        @foreach($managers as $manager)
                            <option value="{{$manager->id}}">
                                {{$manager->name}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="button" @click="updateCalendarSettings" class="btn btn-primary data-submit mr-1">
                    Сохранить
                </button>
                <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                    Отмена
                </button>
            </div>
        </form>
    </div>
</div>