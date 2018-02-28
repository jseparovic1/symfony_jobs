<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class PasswordConfirm extends Constraint
{
    public $message = 'Password must match confirm password.';
    public $field;
    public $confirmField;
    public $entity;

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function getRequiredOptions()
    {
        return ['field', 'confirmField'];
    }
}
