<?php

namespace App\Serializer\Normalizer;

use App\Exception\CommandValidationException;
use App\Factory\ValidationErrorViewFactoryInterface;
use FOS\RestBundle\Serializer\Normalizer\AbstractExceptionNormalizer;
use FOS\RestBundle\Util\ExceptionValueMap;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CommandValidationExceptionNormalizer extends AbstractExceptionNormalizer implements NormalizerInterface
{
    /**
     * @var ValidationErrorViewFactoryInterface
     */
    private $errorViewFactory;

    public function __construct(
        ExceptionValueMap $messagesMap,
        bool $debug,
        ValidationErrorViewFactoryInterface $errorViewFactory
    ) {
        $this->errorViewFactory = $errorViewFactory;
        parent::__construct($messagesMap, $debug);
    }

    /**
     * @param CommandValidationException $object
     * @param null $format
     * @param array $context
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return $this->errorViewFactory->create($object->getViolations());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof CommandValidationException;
    }
}
