<?php

use Carbon\Carbon;

if (!function_exists('getWeekStartDate')) {
    function getWeekStartDate()
    {
        return Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
    }
}
