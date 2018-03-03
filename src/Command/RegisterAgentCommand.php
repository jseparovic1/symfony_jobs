<?php

namespace App\Command;

use Symfony\Component\HttpFoundation\Request;

class RegisterAgentCommand extends Command
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $passwordConfirm;

    public function __construct(Request $request)
    {
        $this->email = $request->request->get('email');
        $this->password = $request->request->get('password');
        $this->passwordConfirm = $request->request->get('passwordConfirm');
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirm(): string
    {
        return $this->passwordConfirm;
    }
}
