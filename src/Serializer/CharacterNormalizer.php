<?php
// src/Serializer/CharacterNormalizer.php

namespace App\Serializer;

use App\Entity\Character;
use App\Entity\Episode;
use App\Utils\DataTransformer\CharacterToArrayTransformer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CharacterNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($topic, $format = null, array $context = [])
    {
        return CharacterToArrayTransformer::transform($topic);
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Character;
    }
}
