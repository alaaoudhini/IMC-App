<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regime;
use App\Models\Imc;
use Illuminate\Http\Request;
use App\Http\Controllers\ImcController;

class UtiregController extends Controller
{
    protected $imcController;

    public function __construct(ImcController $imcController)
    {
        $this->imcController = $imcController;
    }

    public function getRegimeByIMC($user_id, $imc_id)
    {
        $user = User::findOrFail($user_id);
        $imc = Imc::findOrFail($imc_id)->imc;

        $compatibleRegime = $user->getCompatibleRegimeByIMC($imc);

        if (!$compatibleRegime) {
            return response()->json(['message' => 'No compatible regime found for the given IMC'], 404);
        }

        return response()->json(['regime' => $compatibleRegime]);
    }
}
