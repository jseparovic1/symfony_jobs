<?php

namespace App\Validator\Constraint;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CompanyExistsValidator extends ConstraintValidator
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param $value
     * @param Constraint|CompanyExists $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $company = $this->companyRepository->findOneBy(['id' => $value]);
        if (!$company instanceof Company) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
