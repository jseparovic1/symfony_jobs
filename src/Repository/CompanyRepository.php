<?php

namespace App\Repository;

use App\Entity\Company;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CompanyRepository extends BaseRepository
{
    /**
     * CompanyRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Company::class);
    }
}
