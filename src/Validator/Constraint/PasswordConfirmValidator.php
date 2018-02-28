<?php

namespace App\Validator\Constraint;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class UserPasswordValidator
 */
class PasswordConfirmValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($entity, Constraint $constraint)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        if ($accessor->getValue($entity, $constraint->field) !== $accessor->getValue($entity, $constraint->confirmField)) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath($constraint->field)
                ->addViolation();
        }
    }
}
