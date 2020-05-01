<?php

namespace App\Service;

class DateTimeHelper
{
    public function getStartStopDateByWeekNumber(?int $week, int $year = 2020)
    {
        if (!$week) {
            return [null, null];
        }

        $date = new \DateTime();
        $date->setISODate($year, $week);
        $endDate = clone $date;
        $endDate->modify('+6 days');

        return [$date, $endDate];
    }
}
