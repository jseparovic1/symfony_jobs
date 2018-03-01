<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LogoValidator extends ConstraintValidator
{
    const extensions = [
        'image/jpeg' => 'jpeg',
        'image/png' => 'png',
        'image/gif' => 'gif',
    ];

    /**
     * @param $value
     * @param Constraint|PasswordConfirm $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $isBase64 = preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value);

        if ($isBase64 > 1) {
            return $this->context
                ->buildViolation('Invalid image string')
                ->atPath('company.logo')
                ->addViolation();
        }

        [$type, $data] = explode(';', $value);
        [$nothing, $data] = explode(',', $value);

        [$nothing, $extension] = explode(':', $type);

        if (!array_key_exists($extension, self::extensions)) {
            return $this->context
                ->buildViolation('Image type not supported')
                ->atPath('company.logo')
                ->addViolation();
        }
    }
}
