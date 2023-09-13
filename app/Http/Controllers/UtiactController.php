<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Imc;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\ImcController;

class UtiactController extends Controller
{

    protected $imcController;

    public function __construct(ImcController $imcController)
    {
        $this->imcController = $imcController;
    }

    public function getUserImcAndCompatibleActivities($userId, $imcId)
{
    $user = User::findOrFail($userId);

    // Ensure the IMC value belongs to the user
    $imcData = Imc::where('user_id', $userId)->findOrFail($imcId);
    $imc = $imcData->imc;

    if (!$imc) {
        return response()->json(['message' => 'IMC not found for this user.'], 404);
    }

    // Retrieve a compatible activity based on the IMC range
    $compatibleActivity = Activity::where('min_imc', '<=', $imc)
    ->where('max_imc', '>=', $imc)
    ->get();

    if (!$compatibleActivity) {
        return response()->json(['message' => 'No compatible activity found for the given IMC'], 404);
    }

    return response()->json([
        'imc_id' => $imcData->id,
        'imc' => $imc,
        'user' => $user->id,
        'activity' => $compatibleActivity  
    ]);
}



}
