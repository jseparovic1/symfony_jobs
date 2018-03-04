<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Common\Collections\Criteria;
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


    /**
     * @param $search
     * @param null $remote
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function createJobListQueryBuilder($search, $remote = null)
    {
        $queryBuilder = $this->createQueryBuilder('job')
            ->andWhere('job.search LIKE :location OR job.title LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->orderBy('job.createdAt');

        if ($remote) {
            $remoteCriteria = Criteria::create()->where(Criteria::expr()->eq("remote", true));
            $queryBuilder->addCriteria($remoteCriteria);
        }

        return $queryBuilder;
    }
}
