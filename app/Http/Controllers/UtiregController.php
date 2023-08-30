<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Regime;
use App\Models\Imc;
use Illuminate\Http\Request;

class UtiregController extends Controller
{

    public function __construct(ImcController $imcController)
    {
        $this->imcController = $imcController;
    }
    
    public function getUserImcAndCompatibleRegime($userId, $imcId)
    {
        $user = User::findOrFail($userId);
        
        // Ensure the IMC value belongs to the user
        $imcData = Imc::where('user_id', $userId)->findOrFail($imcId);
        $imc = $imcData->imc;

        if (!$imc) {
            return response()->json(['message' => 'IMC not found for this user.'], 404);
        }

        // Define BMI ranges and their corresponding tag types
        $bmiRanges = [
            ['min' => 18, 'max' => 24.8, 'tag' => 'sous_poids'],
            ['min' => 24.9, 'max' => 29.8, 'tag' => 'poids_normal'],
            ['min' => 29.9, 'max' => 34.9, 'tag' => 'surpoids'],
            ['min' => 35, 'max' => 40, 'tag' => 'obesite_moderee'],
            ['min' => 40.1, 'max' => PHP_FLOAT_MAX, 'tag' => 'obesite_severe']
        ];

        $compatibleRegime = null;

        foreach ($bmiRanges as $range) {
            if ($imc <= $range['max']) {
                $compatibleRegime = Regime::where('min_imc_reg', '<=', $imc)
                    ->where('max_imc_reg', '>=', $imc)
                    ->where('type_reg', $range['tag'])
                    ->first();

                if ($compatibleRegime) {
                    break;
                }
            }
        }

        if (!$compatibleRegime) {
            return response()->json(['message' => 'No compatible regime found for the given IMC'], 404);
        }

        return response()->json([
            'imc_id' => $imcData->id, 
            'imc' => $imc,
            'user' => $user->id,
            'regime' => $compatibleRegime
        ]);
    }
}
