<?php

namespace App\Controller\Auth;

use App\Command\ActivateUserCommand;
use App\Controller\BaseAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivateUserAction extends BaseAction
{
    public function __invoke(Request $request)
    {
        $this->bus->handle(new ActivateUserCommand($request));

        return $this->createView(null, Response::HTTP_NO_CONTENT);
    }
}
