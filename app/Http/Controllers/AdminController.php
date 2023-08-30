<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function addUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'date_of_birth' => 'required|date',
            'role' => 'required|string'
        ]);        

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            //'password' => 'sometimes|string|min:6',
            'password' => 'nullable|string|min:6', // Make password field optional
            'date_of_birth' => 'required|date',
            'role' => 'required|string'
        ]);

        /*if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }*/

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getAllUsers()
    {

    $users = User::all();

    return response()->json(['users' => $users]);
    }


    public function getUserImc($userId)
    {
        $user = User::findOrFail($userId);
        $imcRecord = $user->imcRecord;

        if (!$imcRecord) {
            return response()->json(['message' => 'IMC record not found for this user.'], 404);
        }

        return response()->json(['imc' => $imcRecord->imc]);
    }

    public function countActivitiesAndRegimes($userId)
    {
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $user = User::findOrFail($userId);

    $activityCount = $user->activities()->count();
    $regimeCount = $user->regimes()->count();

    return response()->json([
        'activity_count' => $activityCount,
        'regime_count' => $regimeCount,
    ]);
    }
}
