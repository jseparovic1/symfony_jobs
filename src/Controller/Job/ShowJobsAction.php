<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\Factory\JobViewFactory;
use App\Repository\CompanyRepository;
use App\Repository\JobRepository;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ShowJobsAction extends BaseAction
{
    public function __invoke(JobRepository $jobRepository, JobViewFactory $jobViewFactory, UploaderHelper $helper)
    {
        $jobs = $jobRepository->findAll();

        foreach ($jobs as $job) {
            $data[] = $jobViewFactory->create($job);
        }
        return $this->createView($data);
    }
}
