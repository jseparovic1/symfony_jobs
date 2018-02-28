<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use MsgPhp\Domain\Entity\Features\CanBeConfirmed;
use MsgPhp\Domain\Entity\Features\CanBeEnabled;
use MsgPhp\Domain\Entity\Fields\CreatedAtField;
use MsgPhp\User\Entity\Credential\EmailPassword;
use MsgPhp\User\Entity\Features\EmailPasswordCredential;
use MsgPhp\User\Entity\User as BaseUser;
use MsgPhp\User\UserIdInterface;

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

    public function __construct(UserIdInterface $id, string $email, string $password)
    {
        parent::__construct($id);
        $this->enable();
        $this->createdAt = new \DateTime('now');
        $this->credential = new EmailPassword($email, $password);
    }

    /**
     * @return Collection|UserRole[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function setConfirmationToken(string $token)
    {
        $this->confirmationToken = $token;
    }
}
