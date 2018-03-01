<?php

namespace App\Controller\Job;

use App\Command\CreateJobCommand;
use App\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateJobAction extends BaseAction
{
    public function __invoke(Request $request, TokenStorageInterface $tokenStorage)
    {
        $createJobCommand = new CreateJobCommand(
            $request,
            $tokenStorage->getToken()->getUser()
        );

        $company = $request->request->get('company');

        if (is_array($company) && array_key_exists('logo', $company)) {
            $createJobCommand->addValidationGroup('logo');
        }

        if (array_key_exists('id', $company)) {
            $createJobCommand->addValidationGroup('company_entity');
        }

        $job = $this->bus->handle($createJobCommand);

        return $this->createView($job, Response::HTTP_CREATED);
    }
}
