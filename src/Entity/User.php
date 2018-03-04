<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Timestampable\Traits\Timestampable;

class User extends BaseUser implements ResourceInterface
{
    use Timestampable;

    /** @var mixed */
    protected $id;

    /** @var Collection|Company[] */
    private $companies;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email): User
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        $this->setUsernameCanonical($emailCanonical);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCompanies(): ?Collection
    {
        return $this->companies;
    }

    /**
     * @param Company $company
     */
    public function addCompany(Company $company): void
    {
        $this->companies->add($company);
    }

    /**
     * @param Company $company
     */
    public function removeCompany(Company $company): void
    {
        if ($this->companies->contains($company)) {
            $this->companies->remove($company);
        }
    }
}
