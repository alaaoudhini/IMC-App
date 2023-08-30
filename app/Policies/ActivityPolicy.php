<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Activity;

use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
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


