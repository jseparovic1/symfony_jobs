<?php

namespace App\Util;

use Carbon\Carbon;

class JobExpirationCalculator
{
    /**
     * @return Carbon
     */
    public function getExpirationDate()
    {
        $now =  Carbon::now();

        return $now->copy()->subMonthsWithOverflow(2);
    }

    /**
     * @return Carbon
     */
    public function getRenewExpirationDate()
    {
        $now =  Carbon::now();

        return $now->copy()->subMonthsWithOverflow(1);
    }
}
