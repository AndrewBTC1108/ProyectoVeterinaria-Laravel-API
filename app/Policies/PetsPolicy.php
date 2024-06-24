<?php

namespace App\Policies;

use App\Models\Pets;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pets $pets): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return !$user->doctor;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pets $pets): bool
    {
        //solo un usuario que tenga el mismo id de pet->user_id y que no sea doctor puede editar
        return $user->id === $pets->user_id || $user->admin && !$user->doctor;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pets $pets): bool
    {
        //solo un usuario que tenga el mismo id de pet->user_id y que no sea doctor puede eliminar
        return $user->id === $pets->user_id || $user->admin && !$user->doctor;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pets $pets): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pets $pets): bool
    {
        //
    }
}
