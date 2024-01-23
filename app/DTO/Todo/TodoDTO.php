<?php

namespace App\DTO\Todo;

use Spatie\LaravelData\Data;

class TodoDTO extends Data
{
    public string $name;
    public bool $is_done = false;

}
