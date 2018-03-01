<?php

namespace App\Repository;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.emailCanonical = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
