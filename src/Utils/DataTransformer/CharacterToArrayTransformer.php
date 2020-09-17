<?php
// src/Utils/DataTransformer/CharacterToArrayTransformer.php

namespace App\Utils\DataTransformer;

use App\Entity\Character;
use App\Entity\Episode;

class CharacterToArrayTransformer
{
    /**
     * @param Character $character
     * @return array
     */
    public static function transform(Character $character): array
    {
        $episodes = [];

        /** @var Episode $episode */
        foreach ($character->getEpisodes() as $episode) {
            $episodes[] = $episode->getTitle();
        }

        $planet = (empty($character->getPlanet())) ? '' : $character->getPlanet()->getName();

        $friends = [];

        /** @var Character $friend */
        foreach ($character->getFriends() as $friend) {
            $friends[] = $friend->getName();
        }

        return [
            'id' => $character->getId(),
            'name' => $character->getName(),
            'episodes' => $episodes,
            'planet' => $planet,
            'friends' => $friends,
        ];
    }
}
