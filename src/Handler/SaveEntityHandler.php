<?php

namespace App\Handler;

use App\Command\SaveEntityCommand;
use App\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class SaveEntityHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(SaveEntityCommand $entityCommand)
    {
        $entity = $entityCommand->getEntity();

        /** @var RepositoryInterface $entityRepository */
        $entityRepository = $this->entityManager->getRepository(get_class($entity));

        $entityRepository->save($entityCommand->entity);

        return $entityCommand->entity;
    }
}
