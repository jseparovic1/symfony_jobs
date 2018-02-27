<?php

namespace App\Factory;

use App\View\ValidationErrorView;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationErrorViewFactory implements ValidationErrorViewFactoryInterface
{
    /** @var string */
    private $validationErrorViewClass;

    public function __construct(string $validationErrorViewClass)
    {
        $this->validationErrorViewClass = $validationErrorViewClass;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ConstraintViolationListInterface $validationResults): ValidationErrorView
    {
        /** @var ValidationErrorView $errorMessage */
        $errorMessage = new $this->validationErrorViewClass();

        $errorMessage->code = Response::HTTP_BAD_REQUEST;
        $errorMessage->message = 'Validation failed';

        /** @var ConstraintViolationInterface $result */
        foreach ($validationResults as $result) {
            $errorMessage->errors[$result->getPropertyPath()][] = $result->getMessage();
        }

        return $errorMessage;
    }
}