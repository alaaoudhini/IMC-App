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

    public function getActivitiesByIMC($user_id, $imc_id)
    { 
    $user = User::findOrFail($user_id);
    $imc = Imc::findOrFail($imc_id)->imc;

    $compatibleActivities = $user->getCompatibleActivitiesByIMC($imc);

    if ($compatibleActivities->isEmpty()) {
        return response()->json(['message' => 'No compatible activities found for the given IMC'], 404);
    }

    return response()->json(['activities' => $compatibleActivities]);
    }

}
