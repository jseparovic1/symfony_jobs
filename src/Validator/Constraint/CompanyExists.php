<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class CompanyExists extends Constraint
{
    public $message = 'Company does not exists.';
}
