<?php

namespace App\Command;

use App\Entity\ResourceInterface;

/**
 * Class UpdateEntityCommand
 */
class SaveEntityCommand extends Command
{
    /** @var ResourceInterface */
    public $entity;

    /**
     * SaveEntityCommand constructor.
     * @param ResourceInterface $entity
     * @throws \Exception
     */
    public function __construct(ResourceInterface $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return ResourceInterface
     */
    public function getEntity(): ResourceInterface
    {
        return $this->entity;
    }
}
