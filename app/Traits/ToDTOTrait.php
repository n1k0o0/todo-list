<?php

namespace App\Traits;

trait ToDTOTrait
{
    public function toDTO()
    {
        return (new $this->dtoClass(($this->validated())))->only(...array_keys($this->validated()));
    }
}
