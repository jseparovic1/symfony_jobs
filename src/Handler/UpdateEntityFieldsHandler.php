<?php

namespace App\Handler;

use App\Command\UpdateEntityFieldsCommand;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class UpdateEntityFieldsHandler
{
    /**
     * @var PropertyAccessorInterface
     */
    private $accessor;

    public function __construct(PropertyAccessorInterface $accessor)
    {
        $this->accessor = $accessor;
    }

    public function handle(UpdateEntityFieldsCommand $updateEntityFields)
    {
        $input = $updateEntityFields->getInput();
        $allowed = $updateEntityFields->getAllowed();
        $entity = $updateEntityFields->getEntity();

        foreach ($input as $key => $value) {
            if (property_exists($entity, $key) && in_array($key, $allowed)) {
                $this->accessor->setValue($entity, $key, $value);
            }
        }

        return $entity;
    }
}
