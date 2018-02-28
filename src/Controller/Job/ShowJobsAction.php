<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\Repository\CompanyRepository;
use App\Repository\JobRepository;

class ShowJobsAction extends BaseAction
{
    public function __invoke(CompanyRepository $companyRepository)
    {
        return $this->createView(['data' => $companyRepository->findAll()]);
    }
}
