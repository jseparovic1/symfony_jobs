<?php

namespace App\Middleware;

use App\Exception\CommandValidationException;
use App\Factory\ValidationErrorViewFactoryInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use League\Tactician\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorMiddleware implements Middleware
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var ValidationErrorViewFactoryInterface
     */
    private $validationErrorViewFactory;

    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @param ValidatorInterface $validator
     * @param ValidationErrorViewFactoryInterface $validationErrorViewFactory
     * @param ViewHandlerInterface $viewHandler
     */
    public function __construct(
        ValidatorInterface $validator,
        ValidationErrorViewFactoryInterface $validationErrorViewFactory,
        ViewHandlerInterface $viewHandler
    ) {
        $this->validator = $validator;
        $this->validationErrorViewFactory = $validationErrorViewFactory;
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param object $command
     * @param callable $next
     * @return mixed
     * @throws CommandValidationException
     */
    public function execute($command, callable $next)
    {
        $constraintViolations = $this->validator->validate($command);

        if (count($constraintViolations) > 0) {
            throw new CommandValidationException($constraintViolations);
        }

        return $next($command);
    }
}

