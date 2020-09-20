<?php
// src/Utils/Entity/BasicTrait.php

namespace App\Utils\Entity;

use Doctrine\ORM\Mapping as ORM;

trait BasicTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Version()
     * @ORM\Column(type="integer")
     */
    protected $version;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }
}
