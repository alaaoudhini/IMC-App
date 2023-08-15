<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Imc;
use App\Models\Regime;
use App\Models\Activity;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $users = User::all();

    return response()->json(['users' => $users]);
    }


    public function getUserData($user_id)
    {
        $user = User::with('regimes', 'activities', 'imc')->findOrFail($user_id);
    
        $regime_id = $user->regimes->pluck('id');
        $activity_id = $user->activities->pluck('id');
        $imc_id = $user->imc->pluck('id'); 
    
        return response()->json([
            'regime_id' => $regime_id,
            'activity_id' => $activity_id,
            'imc_id' => $imc_id,
        ]);
    }
    
    
}
