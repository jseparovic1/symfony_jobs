<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use MsgPhp\Domain\Entity\Features\CanBeConfirmed;
use MsgPhp\Domain\Entity\Features\CanBeEnabled;
use MsgPhp\Domain\Entity\Fields\CreatedAtField;
use MsgPhp\User\Entity\Features\EmailPasswordCredential;
use MsgPhp\User\Entity\User as BaseUser;

/**
 * @final
 */
class User extends BaseUser
{
    use EmailPasswordCredential;
    use CanBeEnabled;
    use CanBeConfirmed;
    use CreatedAtField;

    /**
     * @var Collection|UserRole[]
     */
    private $roles;

    /**
     * @return Collection|UserRole[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }
}
