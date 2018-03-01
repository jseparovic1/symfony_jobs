<?php

namespace App\Handler;

use App\Command\CreateCompanyCommand;
use App\Entity\Company;
use App\Repository\CompanyRepository;

class CreateCompanyHandler
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function handle(CreateCompanyCommand $createCompanyCommand)
    {
        $company = new Company();

        $company->setContactEmail($createCompanyCommand->contactEmail);
        $company->setName($createCompanyCommand->name);
        $company->setSlogan($createCompanyCommand->slogan);
        $company->setLogo($createCompanyCommand->logo);

        $company->setAgent($createCompanyCommand->agent);

        $this->companyRepository->save($company);

        return $company;
    }
}
