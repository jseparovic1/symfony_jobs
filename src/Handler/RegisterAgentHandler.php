<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Command\RegisterAgentCommand;
use App\Event\UserEvent;
use App\Util\UserEvents;
use League\Tactician\CommandBus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RegisterAgentHandler
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(CommandBus $bus, EventDispatcherInterface $eventDispatcher)
    {
        $this->bus = $bus;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(RegisterAgentCommand $registerAgentCommand)
    {
        $user = $this->bus->handle(new CreateUserCommand(
            $registerAgentCommand->getName(),
            $registerAgentCommand->getEmail(),
            $registerAgentCommand->getPassword()
        ));

        $this->eventDispatcher->dispatch(UserEvents::USER_REGISTER, new UserEvent($user));
    }
}
