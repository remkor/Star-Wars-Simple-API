<?php
// src/DataFixtures/LoadCharacterData.php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Episode;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoadCharacterData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            LoadEpisodeData::class,
            LoadPlanetData::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Load this data from external file
        $samples = [
            [
                'name' => 'Luke Skywalker',
                'episodes' => ['NEWHOPE', 'EMPIRE', 'JEDI'],
                'planet' => '',
            ],
            [
                'name' => 'Darth Vader',
                'episodes' => ['NEWHOPE', 'EMPIRE', 'JEDI'],
                'planet' => '',
            ],
            [
                'name' => 'Han Solo',
                'episodes' => ['NEWHOPE', 'EMPIRE', 'JEDI'],
                'planet' => '',
            ],
            [
                'name' => 'Leia Organa',
                'episodes' => ['NEWHOPE', 'EMPIRE', 'JEDI'],
                'planet' => 'Alderaan',
            ],
            [
                'name' => 'Wilhuff Tarkin',
                'episodes' => ['NEWHOPE'],
                'planet' => '',
            ],
            [
                'name' => 'C-3PO',
                'episodes' => ['NEWHOPE', 'EMPIRE', 'JEDI'],
                'planet' => '',
            ],
            [
                'name' => 'R2-D2',
                'episodes' => ['NEWHOPE', 'EMPIRE', 'JEDI'],
                'planet' => '',
            ],
        ];

        foreach ($samples as $sample) {
            $character = $this->createCharacter($manager, $sample['name'], $sample['episodes'], $sample['planet']);

            $this->addReference('character-' . str_replace(' ', '', $sample['name']), $character);
        }
    }

    /**
     * @param ObjectManager $manager
     * @param string $name
     * @param array $episodes
     * @param string $planet
     * @return Character
     */
    private function createCharacter(ObjectManager $manager, string $name, array $episodes, string $planet): Character
    {
        $character = new Character();

        $character->setName($name);

        /** @var Episode $episode */
        foreach ($episodes as $episode) {
            if (!empty($episode)) {
                $character->addEpisode($this->getReference('episode-' . $episode));
            }
        }

        if (!empty($planet)) {
            $character->setPlanet($this->getReference('planet-' . $planet));
        }

        $manager->persist($character);
        $manager->flush();

        return $character;
    }
}
