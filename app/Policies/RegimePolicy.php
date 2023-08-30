<?php

namespace App\Policies;

use App\Models\User; // Add this import
use App\Models\Regime;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegimePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function edit(User $user, $model)
    {
        return $user->isAdmin(); // Only admin can edit
    }

    public function delete(User $user, $model)
    {
        return $user->isAdmin(); // Only admin can delete
    }
}
