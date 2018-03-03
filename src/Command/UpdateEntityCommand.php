<?php

namespace App\Command;

use App\Entity\Company;
use App\Entity\ResourceInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateEntityCommand
 */
class UpdateEntityCommand extends Command
{
    /** @var array */
    protected $allowed;

    /** @var array */
    protected $input;

    /** @var string */
    protected $entityClass;

    /** @var mixed */
    private $entityId;

    public function __construct(string $entity, $entityId, array $input, array $allowed)
    {
        $this->entityClass = $entity;
        $this->entityId = $entityId;
        $this->input = $input;
        $this->allowed = $allowed;
    }

    /**
     * @return array
     */
    public function getAllowed(): array
    {
        return $this->allowed;
    }

    /**
     * @return array
     */
    public function getInput(): array
    {
        return $this->input;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
}
