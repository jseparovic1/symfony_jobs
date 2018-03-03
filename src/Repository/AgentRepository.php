<?php

namespace App\Repository;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AgentRepository extends BaseRepository
{
    /**
     * AgentRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
}
