<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin(); // Only admin can view
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


