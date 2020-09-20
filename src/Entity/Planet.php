<?php
// src/Entity/Planet.php

namespace App\Entity;

use App\Repository\PlanetRepository;
use App\Utils\Entity\BasicTrait;
use App\Utils\Entity\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanetRepository::class)
 * @ORM\Table(name="planet")
 */
class Planet
{
    use BasicTrait;
    use NameTrait;

    public function __construct()
    {
        $this->name = '';
    }
}
