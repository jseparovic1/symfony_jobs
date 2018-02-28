<?php

namespace App\Command;

use Symfony\Component\HttpFoundation\Request;

class RegisterAgentCommand
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    public function __construct(Request $request)
    {
        $this->email = $request->request->get('email');
        $this->password = $request->request->get('password');
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
