<?php

namespace App\Util\StateMachine\Callbacks\After;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Util\JobExpirationCalculator;

class JobProcessor
{
    public static function process(Job $job)
    {
        $job->setExpirationDate(JobExpirationCalculator::getRenewExpirationDate());
        $job->setRenewed(true);
    }

    /**
     * @param Job $job
     * @return bool
     */
    public static function renewEligibilityChecker(Job $job)
    {
        return !$job->isRenewed();
    }
}
