<?php

namespace App\Command;
use App\Entity\ResourceInterface;


/**
 * Class Command
 */
class Command
{
    protected $validate = true;

    /** @var array */
    protected $validationGroups = ['Default'];

    /** @var ResourceInterface|null */
    protected $entity = null;

    public function addValidationGroup(string $group)
    {
        array_push($this->validationGroups, $group);
    }

    public function removeValidationGroup(string $group)
    {
        array_push($this->validationGroups, $group);
    }

    public function needsToBeValidated()
    {
        return $this->validate;
    }

    public function getValidationGroups(): array
    {
        return $this->validationGroups;
    }

    public function turnOffBusValidation()
    {
        $this->validate = false;
    }

    /**
     * @return ResourceInterface|null
     */
    public function getEntity(): ?ResourceInterface
    {
        return $this->entity;
    }

    /**
     * @param ResourceInterface|null $entity
     */
    public function setEntity(?ResourceInterface $entity): void
    {
        $this->entity = $entity;
    }
}
