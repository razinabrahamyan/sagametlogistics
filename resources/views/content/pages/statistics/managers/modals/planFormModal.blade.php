<div class="modal fade" id="plan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">План</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" v-if="managers[editablePlanManager.id]">
                    <div class="col-12 form-group">
                        <label>План исходящих звонков</label>
                        <input v-model="managers[editablePlanManager.id].plan.outgoing_calls_plan" type="number"
                               class="form-control form-control-sm">
                    </div>
                    <div class="col-12 form-group">
                        <label>План входящих звонков</label>
                        <input v-model="managers[editablePlanManager.id].plan.incoming_calls_plan" type="number"
                               class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"
                        @click="saveManagerPlan(editablePlanManager.id,editablePlanManager.managerCalendarId)">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</div>