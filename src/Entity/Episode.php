<?php
// src/Entity/Episode.php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use App\Utils\Entity\BasicTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EpisodeRepository::class)
 * @ORM\Table(name="episode")
 */
class Episode
{
    use BasicTrait;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;


    public function __construct()
    {
        $this->title = '';
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
