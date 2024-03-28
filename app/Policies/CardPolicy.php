<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->email === 'admin@example.com';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Card $card): Response
    {
        return $user->id === $card->user_id
                ? Response::allow()
                : Response::deny('You do not own this card.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Card $card): Response
    {
        return $user->id === $card->user_id
                ? Response::allow()
                : Response::deny('You do not own this card.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Card $card): Response
    {
        return $user->id === $card->user_id
                ? Response::allow()
                : Response::deny('You do not own this card.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Card $card): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Card $card): bool
    {
        //
    }
}
