<?php

namespace App\Http\Controllers;
use App\Models\Imc;
use App\Models\User; 
use App\Models\Regime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 



class ImcController extends Controller
{
    
    public function calculateIMC(Request $request)
    {
        $weight = $request->input('weight');
        $height = $request->input('height');
    
        // Check if height is zero to avoid division by zero
        if ($height <= 0) {
            return ['error' => 'Invalid height value'];
        }

        $imc = $weight / ($height * $height);

        // Round the IMC to two decimal places
        $imc = round($imc, 2);

        // Create the entry in the 'imc' table
        $imcData = Imc::create([
            'weight' => $weight,
            'height' => $height,
            'imc' => $imc,
        ]);

        // Return the calculated IMC value
        return ['imc' => $imc];
    }

}
