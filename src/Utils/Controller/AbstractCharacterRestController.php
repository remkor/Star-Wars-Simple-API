<?php
// src/Utils/Controller/AbstractCharacterRestController.php

namespace App\Utils\Controller;

use App\Entity\Character;
use App\Entity\Episode;
use App\Entity\Planet;
use App\Utils\Base\AbstractRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

abstract class AbstractCharacterRestController extends AbstractRestController
{
    /**
     * AbstractCharacterRestController constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        parent::__construct($entityManager, $paginator);
    }

    /**
     * @param string $name
     * @return Character
     */
    protected function createCharacter(string $name): Character
    {
        $character = new Character();

        $character->setName($name);

        $this->persistEntity($character);

        return $character;
    }

    /**
     * @param Character $character
     * @param string $name
     * @param array $episodes
     * @param string $planet
     * @param array $friends
     */
    protected function updateCharacter(
        Character &$character,
        string $name,
        array $episodes,
        string $planet,
        array $friends)
    {
        if (!empty($name)) {
            $character->setName($name);
        }

        $this->updateCharacterEpisodes($character, $episodes);

        $this->updateCharacterPlanet($character, $planet);

        $this->updateCharacterFriends($character, $friends);
    }

    /**
     * @param Character $character
     * @param array $episodes
     */
    protected function updateCharacterEpisodes(Character $character, array $episodes)
    {
        $character->setEpisodes(new ArrayCollection());

        foreach ($episodes as $episode) {
            if ($episode instanceof Episode) {
                $title = $episode->getTitle();
            }
            else {
                $title = $episode;
            }

            if (!empty($title)) {
                /** @var Episode $entity */
                $entity = $this->getEntity(Episode::class, ['title' => $title]);

                if (!$entity) {
                    $entity = $this->createEpisode($episode);
                }

                $character->addEpisode($entity);
            }
        }
    }

    /**
     * @param Character $character
     * @param string $planet
     */
    protected function updateCharacterPlanet(Character $character, string $planet)
    {
        $character->setPlanet(null);

        if (!empty($planet)) {
            /** @var Planet $entity */
            $entity = $this->getEntity(Planet::class, ['name' => $planet]);

            if (!$entity) {
                $entity = $this->createPlanet($planet);
            }

            $character->setPlanet($entity);
        }
    }

    /**
     * @param Character $character
     * @param array $friends
     */
    protected function updateCharacterFriends(Character $character, array $friends)
    {
        $character->setFriends(new ArrayCollection());

        foreach ($friends as $friend) {
            if ($friend instanceof Character) {
                $name = $friend->getName();
            }
            else {
                $name = $friend;
            }

            if (!empty($name)) {
                /** @var Character $entity */
                $entity = $this->getEntity(Character::class, ['name' => $name]);

                if (!$entity) {
                    $entity = $this->createCharacter($friend);
                }

                $character->addFriend($entity);
            }
        }
    }

    /**
     * @param string $title
     * @return Episode
     */
    protected function createEpisode(string $title): Episode
    {
        $episode = new Episode();

        $episode->setTitle($title);

        $this->persistEntity($episode);

        return $episode;
    }

    /**
     * @param string $name
     * @return Planet
     */
    protected function createPlanet(string $name): Planet
    {
        $planet = new Planet();

        $planet->setName($name);

        $this->persistEntity($planet);

        return $planet;
    }
}
