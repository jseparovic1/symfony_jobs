<?php

namespace App\Handler;

use App\Command\CreateUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\UserRoleProvider;
use App\Util\Str;
use FOS\UserBundle\Util\Canonicalizer;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CreateUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Canonicalizer
     */
    private $canonicalizer;

    public function __construct(UserRepository $userRepository, CanonicalizerInterface $canonicalizer)
    {
        $this->userRepository = $userRepository;
        $this->canonicalizer = $canonicalizer;
    }

    public function handle(CreateUserCommand $createUserCommand): ?UserInterface
    {
        $user = new User();
        $user->setName($createUserCommand->getName());
        $user->setEmail($createUserCommand->getEmail());
        $user->setEmailCanonical($this->canonicalizer->canonicalize($createUserCommand->getEmail()));
        $user->setPlainPassword($createUserCommand->getPassword());
        $user->addRole(UserRoleProvider::ROLE_AGENT);

        do {
            $token = Str::random(5);
        } while (count($this->userRepository->findBy(['confirmationToken' => $token])) === 1);

        $user->setConfirmationToken(Str::random(10));

        $this->userRepository->save($user);

        return $user;
    }
}
