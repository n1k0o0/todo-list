<?php

namespace App\Traits;

trait ToDTOTrait
{
    public function toDTO()
    {
        return $this->dtoClass::from($this->validated())->only(...array_keys($this->validated()));
    }
}
