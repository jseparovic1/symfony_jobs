<?php

namespace App\Command;

/**
 * Class CreateImageCommand
 */
class CreateImageCommand
{
    /**
     * @var string
     */
    public $base64;

    public function __construct(string $base64)
    {
        $this->base64 = $base64;
    }
}
