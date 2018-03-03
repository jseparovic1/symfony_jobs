<?php

namespace App\Handler;

use App\Command\UpdateEntityCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class UpdateEntityHandler
{
    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PropertyAccessorInterface $accessor, EntityManagerInterface $entityManager)
    {
        $this->accessor = $accessor;
        $this->entityManager = $entityManager;
    }

    public function handle(UpdateEntityCommand $updateEntityFields)
    {
        $input = $updateEntityFields->getInput();
        $allowed = $updateEntityFields->getAllowed();
        $entityClass = $updateEntityFields->getEntityClass();

        /** @var EntityRepository $entityRepository */
        $entityRepository = $this->entityManager->getRepository($entityClass);

        $entity = $entityRepository->findOneBy(['id' => $updateEntityFields->getEntityId()]);

        if (!$entity instanceof $entityClass){
            throw new NotFoundHttpException("{$entityClass} not found");
        }

        foreach ($input as $key => $value) {
            if (property_exists($entity, $key) && in_array($key, $allowed)) {
                $this->accessor->setValue($entity, $key, $value);
            }
        }

        return $entity;
    }
}
