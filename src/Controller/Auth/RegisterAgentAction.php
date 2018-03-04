<?php

namespace App\Controller\Auth;

use App\Command\RegisterAgentCommand;
use App\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterAgentAction extends BaseAction
{
    public function __invoke(Request $request)
    {
        $this->bus->handle(new RegisterAgentCommand($request));

        return $this->createView([], Response::HTTP_CREATED);
    }
}
