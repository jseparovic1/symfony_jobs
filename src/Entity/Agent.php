<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\Timestampable;

/**
 * Class Employer
 */
class Agent implements ResourceInterface
{
    use Timestampable;

    /** @var mixed */
    private $id;

    /** @var Collection|Company[] */
    private $companies;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->companies = new ArrayCollection();
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
