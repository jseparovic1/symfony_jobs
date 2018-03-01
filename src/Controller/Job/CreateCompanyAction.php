<?php

namespace App\Controller\Job;

use App\Command\CreateCompanyCommand;
use App\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateCompanyAction extends BaseAction
{
    public function __invoke(Request $request, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();

        $company = $this->bus->handle(new CreateCompanyCommand($request, $user));

        return $this->createView($company, Response::HTTP_CREATED);
    }
}
