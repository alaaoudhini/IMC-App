<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Imc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImcController;


class UserController extends Controller
{


    public function getUserId()
    {
        $userId = Auth::id(); // This will give you the ID of the currently authenticated user
        
        // Fetch the user's associated IMC value
        $imc = Imc::where('user_id', $userId)->first();
    
        if ($imc) {
            $imcValue = $imc->imc;
            $imcId = $imc->id;
        } else {
            $imcValue = null; // Handle the case when IMC value is not found
            $imcId = null;
            return response()->json(['message' => 'IMC not found for this user.'], 404);
        }
        
        // Fetch the user's avatar path
        $user = User::find($userId);
        $avatarPath = $user->avatar;
    
        return response()->json([
            'user_id' => $userId,
            'imc_id' => $imcId,
            'imc' => $imcValue,
            'avatar_path' => $avatarPath, // Include the avatar path
        ]);
    }
}    

/*protected $imcController;

public function __construct(ImcController $imcController)
{
    $this->imcController = $imcController;
}


 public function getUserImc($userId)
    {
        $user = User::findOrFail($userId);
        $imc = $user->imc;
    
        if (!$imc) {
            return response()->json(['message' => 'IMC not found for this user.'], 404);
        }
    
        return response()->json([
            'imc_id' => $imc->id, // Add this line to fetch the IMC ID
            'imc' => $imc->imc
        ]);
    }*/
