<?php

namespace App\Services;

use App\DTO\Todo\TodoDTO;
use App\Models\Todo;
use Throwable;

class  TodoService
{
    /**
     * @throws Throwable
     */
    public function create(TodoDTO $todoDTO): Todo
    {
        return Todo::create($todoDTO->toArray());
    }

    /**
     * @throws Throwable
     */
    public function update(Todo $todo, TodoDTO $todoDTO): Todo
    {
        $todo->update($todoDTO->toArray());

        return $todo;
    }


}
