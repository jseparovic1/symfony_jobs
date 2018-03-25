<?php

namespace App\Util\StateMachine\Callbacks;

use App\Entity\Job;
use App\Util\JobExpirationCalculator;
use App\Util\Sender;

class JobProcessor
{
    /**
     * @var Sender
     */
    private $sender;

    /**
     * @var JobExpirationCalculator
     */
    private $expirationCalculator;

    public function __construct(Sender $sender, JobExpirationCalculator $expirationCalculator)
    {
        $this->sender = $sender;
        $this->expirationCalculator = $expirationCalculator;
    }

    public function process(Job $job)
    {
        $job->setExpirationDate($this->expirationCalculator->getRenewExpirationDate());
        $job->setRenewed(true);
    }

    /**
     * @param Job $job
     * @return bool
     */
    public function renewEligibilityChecker(Job $job)
    {
        return !$job->isRenewed();
    }

    /**
     * @param Job $job
     */
    public function expire(Job $job)
    {
        $agentEmail = $job->getCompany()->getAgent()->getEmail();

        $this->sender->sendEmail(
            'emails/jobExpired.html.twig',
            'Job expired',
            $agentEmail,
            ['job' => $job, 'agent' => $job->getCompany()->getAgent()]
        );
    }
}
