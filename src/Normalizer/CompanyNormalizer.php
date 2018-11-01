<?php

namespace App\Normalizer;

use App\Entity\Company;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CompanyNormalizer implements NormalizerInterface
{
    /**
     * @param Company $object
     * @param null $format
     * @param array $context
     * @return array|bool|float|int|string
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'name' => $object->getName(),
            'logo' => $object->getLogo(),
            'slogan' => $object->getSlogan(),
        ];
    }

    /**
     * @param mixed $data
     * @param null $format
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Company;
    }
}
