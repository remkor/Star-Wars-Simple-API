<?php
// src/Serializer/CharacterResponseNormalizer.php

namespace App\Serializer;

use App\Model\CharacterResponse;
use App\Utils\DataTransformer\CharacterToArrayTransformer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CharacterResponseNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($topic, $format = null, array $context = [])
    {
        $character = $topic->getCharacter();

        if (!empty($character)) {
            $character = CharacterToArrayTransformer::transform($topic->getCharacter());

            return [
                'character' => $character,
                'result' => $topic->getResult(),
            ];
        }

        return [
            'result' => $topic->getResult(),
        ];
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof CharacterResponse;
    }
}
