<?php

namespace App\Command;

use App\Entity\Company;
use App\Entity\ResourceInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateEntityCommand
 */
class UpdateEntityFieldsCommand extends Command
{
    /** @var array */
    protected $allowed;

    /** @var array */
    protected $input;

    /** @var ResourceInterface */
    protected $entity;

    /** @var bool */
    protected $validate = false;

    public function __construct(ResourceInterface $entity, array $input, array $allowed)
    {
        $this->entity = $entity;
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
     * @return ResourceInterface
     */
    public function getEntity(): ResourceInterface
    {
        return $this->entity;
    }
}
