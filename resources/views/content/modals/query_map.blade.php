<div id="modal-query-map-wrapper" class="scrolling-inside-modal">
    <div class="modal fade" id="query-map-modal" tabindex="-1" role="dialog" aria-labelledby="queryInfoTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="queryInfoTitle">Заявка #{{$query->id}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row overflow-x-hidden mw-100">
                    {{-- Сюда грузим контент через ajax --}}
                </div>
            </div>
        </div>
    </div>
</div>