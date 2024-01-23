<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TodoPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Todo $todo): Response|bool
    {
        return $user->id === $todo->user_id
            ? Response::allow()
            : Response::deny('You do not own this todo.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Todo $todo): Response|bool
    {
        return $user->id === $todo->user_id
            ? Response::allow()
            : Response::deny('You do not own this todo.');
    }

}
