<div class="col-xl-6 col-12">
    <div class="card">
        <div class="card-header flex-column align-items-start">
            <div class="row m-auto">
                <h5 class="card-title mb-75 text-center">Статистика обработанных заявок</h5>
            </div>
            <div class="row m-auto">
                <div class="btn-group btn-group-toggle mt-md-0 mt-1" data-toggle="buttons">
                    <label class="btn btn-outline-primary active btn-stt">
                        <input type="radio" name="radio_options" id="daily_btn"
                               onclick="ApexHandler.allQueriesChart('daily')"/>
                        <span>День</span>
                    </label>
                    <label class="btn btn-outline-primary btn-stt">
                        <input type="radio" name="radio_options" id="weekly_btn"
                               onclick="ApexHandler.allQueriesChart('weekly')"/>
                        <span>Неделя</span>
                    </label>
                    <label class="btn btn-outline-primary btn-stt">
                        <input type="radio" name="radio_options" id="monthly_btn"
                               onclick="ApexHandler.allQueriesChart('monthly')"/>
                        <span>Месяц</span>
                    </label>
                    <label class="btn btn-outline-primary btn-stt">
                        <input type="radio" name="radio_options" id="yearly_btn"
                               onclick="ApexHandler.allQueriesChart('yearly')"/>
                        <span>Год</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="saq_block" id="aq_stat_daily"></div>
        </div>
    </div>
</div>