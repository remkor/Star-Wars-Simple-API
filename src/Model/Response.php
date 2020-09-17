<?php
// src/Model/Response.php

namespace App\Model;

class Response
{
    /**
     * @var string
     */
    protected $result;


    public function __construct()
    {
        $this->result = '';
    }


    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }
}
