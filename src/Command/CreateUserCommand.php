<?php

namespace App\Command;

/**
 * Class CreateUserCommand
 */
class CreateUserCommand extends Command
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $name;

    public function __construct(string $name, string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
