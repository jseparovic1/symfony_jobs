<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Command\RegisterAgentCommand;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;

class RegisterAgentHandler
{
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle(RegisterAgentCommand $registerAgentCommand)
    {
        $userId = Uuid::uuid4();

        $this->bus->handle(new CreateUserCommand(
            $userId,
            $registerAgentCommand->getEmail(),
            $registerAgentCommand->getPassword()
        ));
    }
}
