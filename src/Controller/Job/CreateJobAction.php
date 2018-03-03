<?php

namespace App\Controller\Job;

use App\Command\CreateJobCommand;
use App\Controller\BaseAction;
use App\Factory\JobViewFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateJobAction extends BaseAction
{
    public function __invoke(
        Request $request,
        TokenStorageInterface $tokenStorage,
        JobViewFactory $jobViewFactory
    ) {
        $createJobCommand = new CreateJobCommand(
            $request,
            $tokenStorage->getToken()->getUser()
        );

        $company = $request->request->get('company');

        if (is_array($company) && array_key_exists('name', $company)) {
            $createJobCommand->addValidationGroup('companyName');
        }

        if (is_array($request->files->get('company'))
            && array_key_exists('logo', $request->files->get('company'))
        ) {
            $createJobCommand->addValidationGroup('logo');
        }

        if (is_array($company) && array_key_exists('id', $company)) {
            $createJobCommand->addValidationGroup('companyId');
        }

        $job = $this->bus->handle($createJobCommand);

        return $this->createView($jobViewFactory->create($job), Response::HTTP_CREATED);
    }
}
