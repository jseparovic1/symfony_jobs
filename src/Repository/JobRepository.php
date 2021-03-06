<?php

namespace App\Repository;

use App\Entity\Job;
use Carbon\Carbon;
use Doctrine\Common\Collections\Criteria;
use FOS\UserBundle\Model\UserInterface;
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
            ->andWhere('job.location LIKE :search OR job.title LIKE :search')
            ->andWhere('job.status =:status')
            ->addOrderBy('job.createdAt', 'DESC')
            ->setParameter('search', '%'.$search.'%')
            ->setParameter('status', Job::STATE_ACTIVE)
            ->orderBy('job.createdAt');

        if ($remote === 'true') {
            $remoteCriteria = Criteria::create()->where(Criteria::expr()->eq("remote", true));
            $queryBuilder->addCriteria($remoteCriteria);
        }

        return $queryBuilder;
    }

    public function findByUser(UserInterface $user)
    {
        $queryBuilder = $this->createQueryBuilder('job')
            ->innerJoin('job.company', 'company')
            ->andWhere('company.agent = :agent')
            ->orderBy('job.createdAt')
            ->setParameter('agent', $user)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param string $email
     * @return Job[]|null
     */
    public function findByUserEmail(string $email)
    {
        $queryBuilder = $this->createQueryBuilder('job')
            ->innerJoin('job.company', 'company')
            ->innerJoin('company.agent', 'agent')
            ->andWhere('agent.email = :email')
            ->orderBy('job.createdAt')
            ->setParameter('email', $email)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return Job[]|null
     */
    public function findAllExpired()
    {
        return $this->createQueryBuilder('job')
            ->andWhere('job.status = :status')
            ->andWhere('job.expirationDate < :todayDate')
            ->setParameter('status', Job::STATE_ACTIVE)
            ->setParameter('todayDate', new \DateTimeImmutable('now'))
            ->getQuery()
            ->getResult()
            ;
    }
}
