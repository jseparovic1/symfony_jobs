<?php

namespace App\Controller\Job;

use App\Controller\BaseAction;
use App\Entity\Job;
use App\Factory\JobViewFactory;
use App\Repository\JobRepository;
use App\Util\StateMachine\JobTransitions;
use SM\Factory\FactoryInterface as StateMachineFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RenewAction extends BaseAction
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
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var StateMachineFactory
     */
    private $stateMachineFactory;

    /**
     * RenewAction constructor.
     * @param JobRepository $jobRepository
     * @param JobViewFactory $jobViewFactory
     * @param TokenStorageInterface $tokenStorage
     * @param StateMachineFactory $stateMachineFactory
     */
    public function __construct(
        JobRepository $jobRepository,
        JobViewFactory $jobViewFactory,
        TokenStorageInterface $tokenStorage,
        StateMachineFactory $stateMachineFactory
    ) {
        $this->jobRepository = $jobRepository;
        $this->jobViewFactory = $jobViewFactory;
        $this->tokenStorage = $tokenStorage;
        $this->stateMachineFactory = $stateMachineFactory;
    }

    public function __invoke(Request $request)
    {
        $jobId = $request->attributes->get('jobId');
        $job = $this->jobRepository->findOneBy(['id' => $jobId]);

        if (!$job instanceof Job) {
            throw new NotFoundHttpException("Job not found");
        }

        $jobStateMachine = $this->stateMachineFactory->get($job, JobTransitions::GRAPH);
        if (!$jobStateMachine->can(JobTransitions::TRANSITION_RENEW)) {
            throw new BadRequestHttpException("Job can't be renewed.");
        }
        $jobStateMachine->apply(JobTransitions::TRANSITION_RENEW);
        $this->jobRepository->save($job);

        return $this->createView(null, Response::HTTP_NO_CONTENT);
    }
}
