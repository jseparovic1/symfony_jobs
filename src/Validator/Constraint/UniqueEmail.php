<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class UniqueEmail extends Constraint
{
    public $message = 'This email is already in use.';
}
