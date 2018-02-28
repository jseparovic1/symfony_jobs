<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use App\Entity\UserRole;
use App\Security\UserRoleProvider;
use MsgPhp\User\Infra\Doctrine\Repository\UserRepository;
use MsgPhp\User\Infra\Doctrine\Repository\UserRoleRepository;
use MsgPhp\User\Password\PasswordHashing;
use MsgPhp\User\UserId;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;

class CreateUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserRoleRepository
     */
    private $userRoleRepository;

    /**
     * @var PasswordHashing
     */
    private $passwordHashing;

    public function __construct(
        UserRepository $userRepository,
        UserRoleRepository $userRoleRepository,
        PasswordHashing $passwordHashing
    ) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->passwordHashing = $passwordHashing;
    }

    public function handle(CreateUserCommand $createUserCommand)
    {
        $user = new User(
            new UserId($createUserCommand->getId()),
            $createUserCommand->getEmail(),
            $this->passwordHashing->hash($createUserCommand->getPassword())
        );


        $user->setConfirmationToken(base64_encode(random_bytes(5)));
        $role = new UserRole($user, UserRoleProvider::ROLE_AGENT);

        $this->userRepository->save($user);
        $this->userRoleRepository->save($role);
    }
}
