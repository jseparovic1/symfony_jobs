<?php

namespace App\Validator\Constraint;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEmailValidator extends ConstraintValidator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$this->userRepository->findOneByEmail($value) instanceof User){
            return;
        }

        $this->context
            ->buildViolation($constraint->message)
            ->setParameter('{{ email }}', $value)
            ->addViolation()
        ;
    }
}
