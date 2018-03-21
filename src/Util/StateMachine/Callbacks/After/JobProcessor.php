<?php

namespace App\Util\StateMachine\Callbacks\After;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Util\JobExpirationCalculator;

class JobProcessor
{
    /**
     * @var JobExpirationCalculator
     */
    private $expirationCalculator;

    /**
     * @var JobRepository
     */
    private $jobRepository;

    public function __construct(JobExpirationCalculator $expirationCalculator, JobRepository $jobRepository)
    {
        $this->expirationCalculator = $expirationCalculator;
        $this->jobRepository = $jobRepository;
    }

    public function process(Job $job)
    {
        $job->setExpirationDate(JobExpirationCalculator::getRenewExpirationDate());
        $job->setRenewed(true);
        $this->jobRepository->save($job);
    }
}
