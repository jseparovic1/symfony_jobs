<?php

namespace App\Controller\Agent;

use App\Controller\BaseAction;
use App\Factory\CompanyViewFactory;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShowAgentCompaniesAction extends BaseAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var CompanyViewFactory
     */
    private $companyViewFactory;


    public function __construct(
        TokenStorageInterface $tokenStorage,
        CompanyRepository $companyRepository,
        CompanyViewFactory $companyViewFactory
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->companyRepository = $companyRepository;
        $this->companyViewFactory = $companyViewFactory;
    }

    public function __invoke(Request $request)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $companies = $this->companyRepository->findBy([
            'agent' => $user
        ]);

        $data = [];
        foreach ($companies as $company) {
            $data[] = $this->companyViewFactory->create($company);
        }

        return $this->createView($data);
    }
}
