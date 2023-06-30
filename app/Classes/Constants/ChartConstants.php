<?php

namespace App\Classes\Constants;

class ChartConstants
{
    const YEARLY = "yearly";
    const MONTHLY = "monthly";
    const WEEKLY = "weekly";
    const DAILY = "daily";

    const YEARLY_PERIOD = 3600 * 24 * 365;
    const MONTHLY_PERIOD = 3600 * 24 * 30;
    const WEEKLY_PERIOD = 3600 * 24 * 7;
    const DAILY_PERIOD = 3600 * 24;
}