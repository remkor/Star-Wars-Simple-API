<?php
// src/Model/CharacterResponse.php

namespace App\Model;

use App\Entity\Character;

class CharacterResponse extends Response
{
    /**
     * @var Character
     */
    protected $character;


    public function __construct()
    {
        parent::__construct();

        $this->character = null;
    }


    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    public function setCharacter(Character $character): self
    {
        $this->character = $character;

        return $this;
    }
}
