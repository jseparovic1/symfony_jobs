<?php

namespace App\Controller\Company;

use App\Command\CreateCompanyCommand;
use App\Controller\BaseAction;
use App\Factory\CompanyViewFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateCompanyAction extends BaseAction
{
    public function __invoke(Request $request, TokenStorageInterface $tokenStorage, CompanyViewFactory $companyViewFactory)
    {
        $user = $tokenStorage->getToken()->getUser();

        $createCompanyCommand = new CreateCompanyCommand($request, $user);

        if ($request->files->get('logo') !== null) {
            $createCompanyCommand->addValidationGroup('logo');
        }

        $company = $this->bus->handle($createCompanyCommand);

        return $this->createView($companyViewFactory->create($company), Response::HTTP_CREATED);
    }
}
