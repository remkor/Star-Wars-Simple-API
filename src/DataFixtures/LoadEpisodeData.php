<?php
// src/DataFixtures/LoadEpisodeData.php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class LoadEpisodeData extends AbstractFixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $titles = ['NEWHOPE', 'EMPIRE', 'JEDI'];

        foreach ($titles as $title) {
            $episode = $this->createEpisode($manager, $title);

            $this->addReference('episode-' . $title, $episode);
        }
    }

    /**
     * @param ObjectManager $manager
     * @param string $title
     * @return Episode
     */
    private function createEpisode(ObjectManager $manager, string $title): Episode
    {
        $episode = new Episode();

        $episode->setTitle($title);

        $manager->persist($episode);
        $manager->flush();

        return $episode;
    }
}
