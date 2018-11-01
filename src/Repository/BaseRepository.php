<?php

namespace App\Repository;

use App\Entity\ResourceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class BaseRepository extends ServiceEntityRepository implements RepositoryInterface
{
    /**
     * @param $class
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry, $class)
    {
        parent::__construct($registry, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function save(ResourceInterface $resource): void
    {
        $this->_em->persist($resource);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(ResourceInterface $resource): void
    {
        if (null !== $this->find($resource->getId())) {
            $this->_em->remove($resource);
            $this->_em->flush();
        }
    }
}
