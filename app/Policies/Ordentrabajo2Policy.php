<?php

namespace App\Policies;

use App\Models\Ordentrabajo2;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Ordentrabajo2Policy
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
    public function view(User $user, Ordentrabajo2 $ordentrabajo2): bool
    {
        //
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
    public function update(User $user, Ordentrabajo2 $ordentrabajo2): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ordentrabajo2 $ordentrabajo2): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ordentrabajo2 $ordentrabajo2): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ordentrabajo2 $ordentrabajo2): bool
    {
        //
    }
}
