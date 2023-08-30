<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $test = $request->only('email', 'password');
    
        if ($this->hasNullValues($test)) {
            return response()->json(['error' => 'Email and password fields are required'], 422);
        }
    
        if (Auth::attempt($test)) 
        {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;
    
            return response()->json([
                'message' => 'Authentication successful',
                'user' => $user,
                'token' => $token,
            ]);
        } 
        else
        {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }
    }
    
    

    private function hasNullValues($test)
    {
        foreach ($test as $field => $value) {
            if ($value === null) {
                return true;
            }
        }
        return false;
    }

    public function register(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|string|min:8',
        'date_of_birth' => 'required|date',
    ]);

    // Create a new User instance
    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = bcrypt($request->input('password'));
    $user->date_of_birth = $request->input('date_of_birth');


    // Assign the 'user' role by default
    //$user->role = 'user';

    $user->save();

    return response()->json(['message' => 'Account created successfully']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // User has been successfully logged out
        return response()->json(['message' => 'Logout successful']);
    }

}
