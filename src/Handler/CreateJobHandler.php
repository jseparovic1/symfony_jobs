<?php

namespace App\Handler;

use App\Command\CreateJobCommand;
use App\Entity\Job;
use App\Repository\JobRepository;

class CreateJobHandler
{
    /**
     * @var JobRepository
     */
    private $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function handle(CreateJobCommand $createJobCommand)
    {
        $job = new Job();

        $job->setTitle($createJobCommand->title);
        $job->setDescription($createJobCommand->description);
        $job->setLocation($createJobCommand->location);
        $job->setRemote($createJobCommand->remote);
        $job->setWebsite($createJobCommand->website);

        $this->jobRepository->save($job);

        return $job;
    }
}
