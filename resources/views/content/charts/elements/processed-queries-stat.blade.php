<div class="col-xl-6 col-12">
    <div class="card">
        <div class="card-header flex-column align-items-start">
            <div class="row m-auto">
                <h5 class="card-title mb-75 text-center">Соотношение обработанных и отмененных заявок</h5>
            </div>
            <div class="row m-auto">
                <div class="btn-group btn-group-toggle mt-md-0 mt-1" data-toggle="buttons">
                    <label class="btn btn-outline-primary active btn-stt active">
                        <input type="radio" name="radio_options" id="processed_daily_btn"
                               onclick="ApexHandler.processedChart('#processed_stat','daily')"/>
                        <span>День</span>
                    </label>
                    <label class="btn btn-outline-primary btn-stt">
                        <input type="radio" name="radio_options" id="processed_weekly_btn"
                               onclick="ApexHandler.processedChart('#processed_stat','weekly')"/>
                        <span>Неделя</span>
                    </label>
                    <label class="btn btn-outline-primary btn-stt">
                        <input type="radio" name="radio_options" id="processed_monthly_btn"
                               onclick="ApexHandler.processedChart('#processed_stat','monthly')"/>
                        <span>Месяц</span>
                    </label>
                    <label class="btn btn-outline-primary btn-stt">
                        <input type="radio" name="radio_options" id="processed_yearly_btn"
                               onclick="ApexHandler.processedChart('#processed_stat','yearly')"/>
                        <span>Год</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="saq_block" id="processed_stat"></div>
        </div>
    </div>
</div>