<?php

namespace App\Controller\Job;

use App\Command\SaveEntityCommand;
use App\Command\UpdateEntityFieldsCommand;
use App\Controller\BaseAction;
use App\Entity\Job;
use App\Factory\JobViewFactory;
use App\Repository\JobRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditJobAction extends BaseAction
{
    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * @var JobViewFactory
     */
    private $jobViewFactory;

    /**
     * EditJobAction constructor.
     * @param JobRepository $jobRepository
     * @param JobViewFactory $jobViewFactory
     */
    public function __construct(JobRepository $jobRepository, JobViewFactory $jobViewFactory)
    {
        $this->jobRepository = $jobRepository;
        $this->jobViewFactory = $jobViewFactory;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->attributes->get('id');

        /** @var Job $job */
        $job = $this->jobRepository->findOneBy(['id' => $id]);

        if (!$job instanceof Job){
            throw new NotFoundHttpException("Job not found");
        }

        $job = $this->bus->handle(new UpdateEntityFieldsCommand(
            $job,
            $request->request->all(),
            ['description', 'website', 'location', 'title', 'remote']
        ));

        $job = $this->bus->handle(new SaveEntityCommand($job));
        return $this->createView($this->jobViewFactory->create($job));
    }
}
