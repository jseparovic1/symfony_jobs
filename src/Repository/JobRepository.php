<?php

namespace App\Repository;

use App\Entity\Job;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JobRepository extends BaseRepository
{
    /**
     * JobRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
    }
}
