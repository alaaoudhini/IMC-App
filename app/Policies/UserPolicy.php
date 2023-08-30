<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function addUser(User $user)
    {
        return $user->isAdmin();
    }

    public function updateUser(User $user, $model)
    {
        return $user->isAdmin(); // Only admin can edit user
    }

    public function deleteUser(User $user, $model)
    {
        return $user->isAdmin(); // Only admin can delete user
    }
}
