<?php

namespace App\Http\Controllers;
use App\Models\Imc;
use App\Models\User; 
use App\Models\Regime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class AvatarController extends Controller
{
    public function uploadAvatar(Request $request)
{
    // Get the currently authenticated user
    $user = Auth::user();

    // Validate the uploaded file
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
    ]);

    // Check if an avatar file is present in the request
    if ($request->hasFile('avatar')) {
        try {
            // Upload the avatar and update the path in the database
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();

            return response()->json(['message' => 'Avatar updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Avatar upload failed'], 500);
        }
    } else {
        return response()->json(['message' => 'No avatar provided'], 400);
    }
}

public function getAvatar($userId)
{
    $user = User::findOrFail($userId); // Find the user by the provided user ID

    $avatarPath = $user->avatar;

    if ($avatarPath) {
        $avatar = Storage::disk('public')->get($avatarPath);

        return response($avatar)->header('Content-Type', 'image/jpeg');
    } else {
        abort(Response::HTTP_NOT_FOUND, 'Avatar not found.');
    }
}
    
    
    
    
}
