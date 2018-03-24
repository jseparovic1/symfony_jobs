<?php

namespace App\Util;

use Carbon\Carbon;

class JobExpirationCalculator
{
    /**
     * @return bool|\DateTime
     */
    public function getExpirationDate()
    {
        $now = Carbon::now();

        return $now->copy()->addMonthsWithOverflow(2);
    }

    /**
     * @return Carbon
     */
    public static function getRenewExpirationDate()
    {
        $now =  Carbon::now();

        return $now->copy()->addMonthsWithOverflow(1);
    }
}
