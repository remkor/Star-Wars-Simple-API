<?php
// src/DataFixtures/LoadPlanetData.php

namespace App\DataFixtures;

use App\Entity\Planet;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class LoadPlanetData extends AbstractFixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $names = ['Alderaan'];

        foreach ($names as $name) {
            $planet = $this->createPlanet($manager, $name);

            $this->addReference('planet-' . $name, $planet);
        }
    }

    /**
     * @param ObjectManager $manager
     * @param string $title
     * @return Planet
     */
    private function createPlanet(ObjectManager $manager, string $name): Planet
    {
        $episode = new Planet();

        $episode->setName($name);

        $manager->persist($episode);
        $manager->flush();

        return $episode;
    }
}
