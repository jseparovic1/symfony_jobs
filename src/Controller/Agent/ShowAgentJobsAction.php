<?php

namespace App\Controller\Agent;

use App\Controller\BaseAction;
use App\Factory\JobViewFactory;
use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShowAgentJobsAction extends BaseAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * @var JobViewFactory
     */
    private $jobViewFactory;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        JobRepository $jobRepository,
        JobViewFactory $jobViewFactory
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->jobRepository = $jobRepository;
        $this->jobViewFactory = $jobViewFactory;
    }

    public function __invoke(Request $request)
    {
        $jobs = $this->jobRepository->findByUser($this->tokenStorage->getToken()->getUser());

        $data = new ArrayCollection([]);
        foreach ($jobs as $job) {
            $data->add($this->jobViewFactory->create($job));
        }

        return $this->createView($data);
    }
}
