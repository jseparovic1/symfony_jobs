<?php

namespace App\Repository;

use App\Entity\ResourceInterface;

interface RepositoryInterface
{
    public function save(ResourceInterface $resource);

    public function remove(ResourceInterface $resource);
}
