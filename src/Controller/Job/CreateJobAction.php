<?php

namespace App\Controller\Job;

use App\Command\CreateJobCommand;
use App\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateJobAction extends BaseAction
{
    public function __invoke(Request $request)
    {
        $job = $this->bus->handle(new CreateJobCommand($request));

        return $this->createView($job, Response::HTTP_CREATED);
    }
}
