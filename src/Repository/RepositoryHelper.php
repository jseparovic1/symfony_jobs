<?php

namespace App\Repository;

use App\Entity\ResourceInterface;
use Doctrine\ORM\EntityManager;

trait RepositoryHelper
{
    /**
     * @var EntityManager
     */
    protected $_em;

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
        if (null !== $this->_em->find(get_class($resource), $resource->getId())) {
            $this->_em->remove($resource);
            $this->_em->flush();
        }
    }
}