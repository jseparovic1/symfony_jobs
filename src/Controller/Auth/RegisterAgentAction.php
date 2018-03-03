<?php

namespace App\Controller\Auth;

use App\Command\RegisterAgentCommand;
use App\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;

class RegisterAgentAction extends BaseAction
{
    public function __invoke(Request $request)
    {
        $this->bus->handle(new RegisterAgentCommand($request));

        return $this->createView([
            'status' => '200',
            'message' => 'User created successfully.'
        ]);
    }
}
