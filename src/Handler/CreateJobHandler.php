<?php

namespace App\Handler;

use App\Command\CreateJobCommand;
use App\Entity\Company;
use App\Entity\Job;
use App\Repository\CompanyRepository;
use App\Repository\JobRepository;
use App\Util\JobExpirationCalculator;
use App\Util\StateMachine\JobTransitions;
use League\Tactician\CommandBus;
use SM\Factory\FactoryInterface;
use Vich\UploaderBundle\Handler\UploadHandler;

class CreateJobHandler
{
    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var UploadHandler
     */
    private $uploadHandler;

    /**
     * @var JobExpirationCalculator
     */
    private $expirationCalculator;

    /**
     * @var FactoryInterface
     */
    private $stateMachineFactory;

    public function __construct(
        JobRepository $jobRepository,
        CompanyRepository $companyRepository,
        CommandBus $bus,
        UploadHandler $uploadHandler,
        JobExpirationCalculator $expirationCalculator,
        FactoryInterface $stateMachineFactory
    ) {
        $this->jobRepository = $jobRepository;
        $this->companyRepository = $companyRepository;
        $this->bus = $bus;
        $this->uploadHandler = $uploadHandler;
        $this->expirationCalculator = $expirationCalculator;
        $this->stateMachineFactory = $stateMachineFactory;
    }

    /**
     * @param CreateJobCommand $createJobCommand
     * @return Job
     * @throws \SM\SMException
     */
    public function handle(CreateJobCommand $createJobCommand)
    {
        $job = new Job();

        $job->setTitle($createJobCommand->title);
        $job->setDescription($createJobCommand->description);
        $job->setLocation($createJobCommand->location);
        $job->setRemote($createJobCommand->remote);
        $job->setWebsite($createJobCommand->website);
        $job->setAuthor($createJobCommand->user);
        $job->setExpirationDate($this->expirationCalculator->getExpirationDate());

        //TODO job needs to be paid in future!
        $jobStateMachine = $this->stateMachineFactory->get($job, JobTransitions::GRAPH);
        $jobStateMachine->apply(JobTransitions::TRANSITION_PAY);
        
        $company = null;
        if ($id = $createJobCommand->companyId) {
            /** @var Company $company */
            $company = $this->companyRepository->findOneBy(['id' => $id]);
        } else {
            $company = new Company();

            $company->setName($createJobCommand->companyName);
            $company->setAgent($createJobCommand->user);
            $company->setSlogan($createJobCommand->companySlogan);
            $company->setLogoFile($createJobCommand->companyLogo);
        }

        $job->setCompany($company);

        $this->companyRepository->save($company);
        $this->jobRepository->save($job);

        return $job;
    }
}
