<?php

namespace App\Traits;

use Carbon\Carbon;

trait Datable
{
    public function weekDays()
    {
        return ['日', '月', '火', '水', '木', '金', '土'];
    }

    public function createCalendar ($yyyymm)
    {
        $date = new Carbon(date('Y-m-01', strtotime("{$yyyymm}01")));
        $date->subDay($date->dayOfWeek);

        $count    = 31 + $date->dayOfWeek;
        $count    = ceil($count / 7) * 7;
        $calendar = [];

        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $calendar[] = $date->copy();
        }

        return $calendar;
    }

    public function createDateList ($yyyymm)
    {
        $date    = new Carbon(date('Y-m-01', strtotime("{$yyyymm}01")));
        $list    = [];
        $end_day = (int) $date->format('t');
        for ($i = 1; $i <= $end_day; $i++, $date->addDay()) {
            $list[] = $date->copy();
        }
        return $list;
    }
}
