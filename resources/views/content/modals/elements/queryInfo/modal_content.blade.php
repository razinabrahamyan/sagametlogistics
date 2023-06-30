<div class="modal-header">
    <h5 class="modal-title" id="queryInfoTitle">Заявка #{{$query->id}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body row overflow-x-hidden mw-100">
    @include('content.modals.elements.queryInfo.base_table')
    @include('content.modals.elements.queryInfo.crew')
    @include('content.modals.elements.queryInfo.photos_preview')
    @include('content.modals.elements.queryInfo.videos_preview')
</div>
<div class="modal-footer">
    @include('content.modals.elements.queryInfo.actions',['query' => $query])
</div>
