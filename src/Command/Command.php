<?php

namespace App\Command;


/**
 * Class Command
 */
class Command
{
    protected $validate = true;

    /** @var array */
    protected $validationGroups = ['Default'];

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
}
