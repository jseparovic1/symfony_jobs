<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\ViewRepository\JobsViewRepository;
use Symfony\Component\HttpFoundation\Request;

class ShowJobsAction extends BaseAction
{
    /**
     * @param Request $request
     * @param JobsViewRepository $jobsViewRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function __invoke(Request $request, JobsViewRepository $jobsViewRepository)
    {
        return $this->createView($jobsViewRepository->findAllJobs(
            $request,
            $request->query->get('search'),
            $request->query->get('remote')
        ));
    }
}
