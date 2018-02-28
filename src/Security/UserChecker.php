<?php
namespace App\Security;

use App\Entity\User;
use MsgPhp\User\Infra\Security\SecurityUser;
use MsgPhp\User\Infra\Uuid\UserId;
use MsgPhp\User\Repository\UserRepositoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{
    private $repository;
    private $logger;

    public function __construct(UserRepositoryInterface $repository, LoggerInterface $logger = null)
    {
        $this->repository = $repository;
        $this->logger = $logger ?? new NullLogger();
    }
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof SecurityUser) {
            return;
        }

        $userId = UserId::fromValue($user->getUsername());

        /** @var User $user */
        $user = $this->repository->find($userId);

        if (!$user->isConfirmed()) {
            $this->logger->info('Disabled user login attempt.', ['id' => $user->getId()->toString(), 'email' => $user->getEmail()]);
            throw new BadRequestHttpException('Please check your email and activate your account first.');
        }
    }
    public function checkPostAuth(UserInterface $user): void
    {
    }
}