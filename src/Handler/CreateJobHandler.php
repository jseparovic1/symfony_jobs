<?php

namespace App\Handler;

use App\Command\CreateJobCommand;
use App\Entity\Company;
use App\Entity\Job;
use App\Repository\CompanyRepository;
use App\Repository\JobRepository;
use App\Util\JobExpirationCalculator;
use League\Tactician\CommandBus;
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

    public function __construct(
        JobRepository $jobRepository,
        CompanyRepository $companyRepository,
        CommandBus $bus,
        UploadHandler $uploadHandler,
        JobExpirationCalculator $expirationCalculator
    ) {
        $this->jobRepository = $jobRepository;
        $this->companyRepository = $companyRepository;
        $this->bus = $bus;
        $this->uploadHandler = $uploadHandler;
        $this->expirationCalculator = $expirationCalculator;
    }

    public function handle(CreateJobCommand $createJobCommand)
    {
        $job = new Job();

        $job->setTitle($createJobCommand->title);
        $job->setDescription($createJobCommand->description);
        $job->setLocation($createJobCommand->location);
        $job->setRemote($createJobCommand->remote);
        $job->setWebsite($createJobCommand->website);
        $job->setExpirationDate($this->expirationCalculator->getExpirationDate());

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
