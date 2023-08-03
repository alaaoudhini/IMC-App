<?php

namespace App\Http\Controllers;
use App\Models\Regime; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

class RegimeController extends Controller
{
    public function index()
    {
        // Récupérer toutes les regimes
        $regimes = Regime::all();
        return response()->json(['regimes' => $regimes]);
    }

    public function show($id)
    {
    // Récupérer un regime spécifique par son identifiant
    $regime = Regime::findOrFail($id);

    return response()->json(['regime' => $regime]);
    }

    public function store(Request $request)
    {
    // Valider les données entrantes
    $validator = Validator::make($request->all(), [
        'nom_reg' => 'required|string|max:255',
        'description_reg' => 'required|string',
        'type_reg' => 'required|string',
        'calories_reg' => 'required|numeric',
        'max_imc_reg' => 'required|numeric',
        'min_imc_reg' => 'required|numeric',
        // Ajoutez ici d'autres règles de validation selon vos besoins
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Vérifier si l'utilisateur a l'autorisation de créer des regimes (rôle admin)
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Get the authenticated user who is creating the activity
    $user = $request->user();

    // Créer un nouvel regime avec le 'user_id' défini par l'utilisateur authentifié
    $regime = Regime::create([
        'nom_reg' => $request->input('nom_reg'),
        'description_reg' => $request->input('description_reg'),
        'calories_reg' => $request->input('calories_reg'),
        'type_reg' => $request->input('type_reg'),
        'max_imc_reg' => $request->input('max_imc_reg'),
        'min_imc_reg' => $request->input('min_imc_reg'),
        'user_id' => $user->id, // Set the user_id here
    ]);

    return response()->json(['regime' => $regime], 201);
    }

    public function update(Request $request, $id)
    {
    // Valider les données entrantes
    $validator = Validator::make($request->all(), [
        'nom_reg' => 'required|string|max:255',
        'description_reg' => 'required|string',
        'type_reg' => 'required|string',
        'calories_reg' => 'required|numeric',
        'max_imc_reg' => 'required|numeric',
        'min_imc_reg' => 'required|numeric',
        // Ajoutez ici d'autres règles de validation selon vos besoins
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Vérifier si l'utilisateur a l'autorisation de mettre à jour des regimes (rôle admin)
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Get the authenticated user who is updating the activity
    $user = $request->user();

    // Récupérer le regime par son identifiant
    $regime = Regime::findOrFail($id);

    // Mettre à jour l'activité
    $regime->update([
        'nom_reg' => $request->input('nom_reg'),
        'description_reg' => $request->input('description_reg'),
        'calories_reg' => $request->input('calories_reg'),
        'type_reg' => $request->input('type_reg'),
        'max_imc_reg' => $request->input('max_imc_reg'),
        'min_imc_reg' => $request->input('min_imc_reg'),
        'user_id' => $user->id, // Set the user_id here
    ]);

    return response()->json(['regime' => $regime], 200);
   }

    public function destroy($id)
    {
        // Récupérer de regime par son identifiant
        $regime = Regime::findOrFail($id);

        // Vérifier si l'utilisateur a l'autorisation de supprimer des regimes (rôle admin)
        if (auth()->user()->role !== 'admin'){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Supprimer le regime
        $regime->delete();

        return response()->json(['message' => 'Regime deleted successfully'], 200);
    }
}
