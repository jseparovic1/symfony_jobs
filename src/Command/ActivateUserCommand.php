<?php

namespace App\Command;

use Symfony\Component\HttpFoundation\Request;

class ActivateUserCommand extends Command
{
    /**
     * @var mixed
     */
    private $userId;

    /**
     * @var mixed
     */
    private $confirmationToken;

    public function __construct(Request $request)
    {
        $this->userId = $request->request->get('userId');
        $this->confirmationToken = $request->request->get('confirmationToken');
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }
}
