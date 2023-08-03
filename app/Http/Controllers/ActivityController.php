<?php

namespace App\Http\Controllers;
use App\Models\Activity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

class ActivityController extends Controller
{
    public function index()
    {
        // Récupérer toutes les activités
        $activities = Activity::all();
        return response()->json(['activities' => $activities]);
    }

    public function show($id)
    {
    // Récupérer une activité spécifique par son identifiant
    $activity = Activity::findOrFail($id);

    return response()->json(['activity' => $activity]);
    }

    public function store(Request $request)
    {
    // Valider les données entrantes
    $validator = Validator::make($request->all(), [
        'nom_act' => 'required|string|max:255',
        'description_act' => 'required|string',
        'type_act' => 'required|string',
        'max_imc' => 'required|numeric',
        'min_imc' => 'required|numeric',
        'video' => 'required|string',
        // Ajoutez ici d'autres règles de validation selon vos besoins
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Vérifier si l'utilisateur a l'autorisation de créer des activités (rôle admin)
    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Get the authenticated user who is creating the activity
    $user = $request->user();

    // Créer une nouvelle activité avec le 'user_id' défini par l'utilisateur authentifié
    $activity = Activity::create([
        'nom_act' => $request->input('nom_act'),
        'description_act' => $request->input('description_act'),
        'type_act' => $request->input('type_act'),
        'max_imc' => $request->input('max_imc'),
        'min_imc' => $request->input('min_imc'),
        'video' => $request->input('video'),
        'user_id' => $user->id, // Set the user_id here
    ]);

    return response()->json(['activity' => $activity], 201);
    }

    public function update(Request $request, $id)
    {
        // Valider les données entrantes
        $validator = Validator::make($request->all(), [
            'nom_act' => 'required|string|max:255',
            'description_act' => 'required|string',
            'type_act' => 'required|string',
            'max_imc' => 'required|numeric',
            'min_imc' => 'required|numeric',
            'video' => 'required|string',
            // Ajoutez ici d'autres règles de validation selon vos besoins
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Vérifier si l'utilisateur a l'autorisation de mettre à jour des activités (rôle admin)
        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Get the authenticated user who is creating the activity
        $user = $request->user();

        // Mettre à jour l'activité
        $activity = Activity::findOrFail($id);
        $activity->update([
            'nom_act' => $request->input('nom_act'),
            'description_act' => $request->input('description_act'),
            'type_act' => $request->input('type_act'),
            'max_imc' => $request->input('max_imc'),
            'min_imc' => $request->input('min_imc'),
            'video' => $request->input('video'),
            // Ajoutez ici d'autres champs à mettre à jour selon votre modèle
        ]);

        return response()->json(['activity' => $activity], 200);
    }

    public function destroy($id)
    {
        // Récupérer l'activité par son identifiant
        $activity = Activity::findOrFail($id);

        // Vérifier si l'utilisateur a l'autorisation de supprimer des activités (rôle admin)
        if (auth()->user()->role !== 'admin'){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Supprimer l'activité
        $activity->delete();

        return response()->json(['message' => 'Activity deleted successfully'], 200);
    }
}
