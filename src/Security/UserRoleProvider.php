<?php

namespace App\Security;

use App\Entity\UserRole as AppUserRole;
use MsgPhp\User\Entity\User;
use MsgPhp\User\Infra\Security\UserRolesProviderInterface;

class UserRoleProvider implements UserRolesProviderInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_DISABLED_USER = 'ROLE_DISABLED_USER';
    public const ROLE_AGENT = 'ROLE_AGENT';

    /**
     * @param User|\App\Entity\User $user
     * @return array
     */
    public function getRoles(User $user): array
    {
        $roles = $user->isEnabled() ? [self::ROLE_USER] : [self::ROLE_DISABLED_USER];
        return array_merge($roles, $user->getRoles()->map(function (AppUserRole $userRole) {
            return $userRole->getRole();
        })->toArray());
    }
}