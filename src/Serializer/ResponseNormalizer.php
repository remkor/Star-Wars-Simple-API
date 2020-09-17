<?php
// src/Serializer/ResponseNormalizer.php

namespace App\Serializer;

use App\Model\Response;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ResponseNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($topic, $format = null, array $context = [])
    {
        return [
            'result' => $topic->getResult(),
        ];
    }

    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Response;
    }
}
