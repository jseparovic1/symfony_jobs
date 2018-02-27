<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class CommandValidationException extends \Exception
{
    private $statusCode;
    private $headers;

    /** @var ConstraintViolationListInterface */
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations, int $statusCode = 400, string $message = null, \Exception $previous = null, array $headers = array(), ?int $code = 0)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->violations = $violations;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations()
    {
        return $this->violations;
    }
}
