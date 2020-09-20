<?php
// src/Utils/Entity/NameTrait.php

namespace App\Utils\Entity;

use Doctrine\ORM\Mapping as ORM;

trait NameTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
