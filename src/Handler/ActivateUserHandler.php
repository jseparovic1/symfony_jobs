<?php

namespace App\Handler;

use App\Command\ActivateUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Util\ConfirmationTokenGenerator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActivateUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ConfirmationTokenGenerator
     */
    private $generator;

    public function __construct(UserRepository $userRepository, ConfirmationTokenGenerator $generator)
    {
        $this->userRepository = $userRepository;
        $this->generator = $generator;
    }

    public function handle(ActivateUserCommand $activateUserCommand)
    {
        $user = $this->userRepository->findOneBy([
            'id' => $activateUserCommand->getUserId(),
            'confirmationToken' => $activateUserCommand->getConfirmationToken()
        ]);

        if (!$user instanceof User) {
            throw new NotFoundHttpException("User with provided token not found.");
        }

        $user->setEnabled(true);
        $user->setConfirmationToken($this->generator->generate());

        $this->userRepository->save($user);

        return $user;
    }
}
