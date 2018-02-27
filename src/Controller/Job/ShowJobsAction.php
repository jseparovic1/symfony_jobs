<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\Repository\JobRepository;

class ShowJobsAction extends BaseAction
{
    public function __invoke(JobRepository $jobRepository)
    {
        return $this->createView($jobRepository->findAll());
    }
}
