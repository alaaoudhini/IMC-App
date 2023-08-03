<?php

use Illuminate\Http\Request;
use App\Http\Middleware\VerifRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegimeController;
use App\Http\Controllers\ActivityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api', 'role:admin']], function () {

    Route::get('activities', [ActivityController::class, 'index']);

    Route::get('activities/{id}', [ActivityController::class, 'show']);

    //créer une activité (réservé aux administrateurs)
    Route::post('activities', [ActivityController::class, 'store']);

    //mettre à jour une activité (réservé aux administrateurs)
    Route::put('activities/{id}', [ActivityController::class, 'update']);

    //supprimer une activité (réservé aux administrateurs)
    Route::delete('activities/{id}', [ActivityController::class, 'destroy']);

    //afficher tous les utilisateurs (réservé aux administrateurs) 
    Route::get('regimes', [RegimeController::class, 'index']);

    //afficher tous les utilisateurs avec l'id (réservé aux administrateurs)
    Route::get('regimes/{id}', [RegimeController::class, 'show']);

    //créer un regime (réservé aux administrateurs)
    Route::post('regimes', [RegimeController::class, 'store']);

    //mettre à jour un regime  (réservé aux administrateurs)
    Route::put('regimes/{id}', [RegimeController::class, 'update']);

    //supprimer un regime  (réservé aux administrateurs)
    Route::delete('regimes/{id}', [RegimeController::class, 'destroy']);

    //créer un utilisateur (réservé aux administrateurs)
    Route::post('users', [AdminController::class ,'addUser']);
    
    //mettre à jour un utilisateur  (réservé aux administrateurs)
    Route::put('users/{id}', [AdminController::class ,'updateUser']);

    //supprimer un utilisateur  (réservé aux administrateurs)
    Route::delete('users/{id}', [AdminController::class ,'deleteUser']);

});

