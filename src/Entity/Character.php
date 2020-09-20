<?php
// src/Entity/Character.php

namespace App\Entity;

use App\Repository\CharacterRepository;
use App\Utils\Entity\BasicTrait;
use App\Utils\Entity\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character
{
    use BasicTrait;
    use NameTrait;


    /**
     * @ManyToMany(targetEntity="Episode")
     * @JoinTable(
     *     name="character_episodes",
     *     joinColumns={@JoinColumn(name="character_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="episode_id", referencedColumnName="id")})
     */
    private $episodes;

    /**
     * @ManyToOne(targetEntity="Planet")
     * @JoinColumn(name="planet_id", referencedColumnName="id")
     */
    private $planet;

    /**
     * @ManyToMany(targetEntity="Character")
     * @JoinTable(
     *     name="character_friends",
     *     joinColumns={@JoinColumn(name="character_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="friend_id", referencedColumnName="id")})
     */
    private $friends;


    public function __construct()
    {
        $this->name = '';

        $this->episodes = new ArrayCollection();

        $this->planet = null;

        $this->friends = new ArrayCollection();
    }


    public function getEpisodes()
    {
        return $this->episodes;
    }

    public function setEpisodes(ArrayCollection $episodes): self
    {
        $this->episodes = $episodes;

        return $this;
    }

    public function getPlanet(): ?Planet
    {
        return $this->planet;
    }

    public function setPlanet(?Planet $planet): self
    {
        $this->planet = $planet;

        return $this;
    }

    public function getFriends()
    {
        return $this->friends;
    }

    public function setFriends(ArrayCollection $friends): self
    {
        $this->friends = $friends;

        return $this;
    }


    public function addEpisode(Episode $episode)
    {
        $this->episodes->add($episode);
    }

    public function removeEpisode(Episode $episode)
    {
        $this->episodes->removeElement($episode);
    }

    public function addFriend(Character $character)
    {
        $this->friends->add($character);
    }

    public function removeFriend(Character $character)
    {
        $this->friends->removeElement($character);
    }
}
