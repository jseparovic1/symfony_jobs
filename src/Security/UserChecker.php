<?php

namespace App\Security;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new NullLogger();
    }
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isEnabled()) {
            $this->logger->info('Disabled user login attempt.', ['id' => $user->getId()->toString(), 'email' => $user->getEmail()]);
            throw new BadRequestHttpException('Please activate your account first.');
        }
    }
    public function checkPostAuth(UserInterface $user): void
    {
    }
}
