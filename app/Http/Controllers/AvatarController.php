<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function updateAvatar(Request $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifier si un fichier d'avatar est présent dans la requête
        if ($request->hasFile('avatar')) {
            // Télécharger l'avatar et mettre à jour le chemin dans la base de données
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();
            
            return response()->json(['message' => 'Avatar updated successfully']);
        } else {
            return response()->json(['message' => 'No avatar provided'], 400);
        }
    }
}
