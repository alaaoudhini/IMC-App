<?php

use Illuminate\Http\Request;
use App\Http\Middleware\VerifRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImcController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegimeController;
use App\Http\Controllers\UtiregController;
use App\Http\Controllers\UtiactController;
use App\Http\Controllers\AvatarController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// with policies 
/*Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    
    // Permissions for viewing any model
    Route::get('activities', [ActivityController::class, 'index'])->middleware('can:viewAny,' . Activity::class);
    Route::get('activities/{id}', [ActivityController::class, 'show']);
    Route::get('regimes', [RegimeController::class, 'index'])->middleware('can:viewAny,' . Regime::class);
    Route::get('regimes/{id}', [RegimeController::class, 'show']);

    // Permissions for editing any model
    Route::post('activities', [ActivityController::class, 'store'])->middleware('can:edit,' . Activity::class);
    Route::put('activities/{id}', [ActivityController::class, 'update'])->middleware('can:edit,' . Activity::class);
    Route::post('regimes', [RegimeController::class, 'store'])->middleware('can:edit,' . Regime::class);
    Route::put('regimes/{id}', [RegimeController::class, 'update'])->middleware('can:edit,' . Regime::class);

    // Other admin-only routes
    Route::delete('activities/{id}', [ActivityController::class, 'destroy'])->middleware('can:delete,' . Activity::class);
    Route::delete('regimes/{id}', [RegimeController::class, 'destroy'])->middleware('can:delete,' . Regime::class);
    
    Route::post('users', [AdminController::class, 'addUser'])->middleware('can:addUser,' . User::class);
    Route::put('users/{id}', [AdminController::class, 'updateUser'])->middleware('can:updateUser,' . User::class);
    Route::delete('users/{id}', [AdminController::class, 'deleteUser'])->middleware('can:deleteUser,' . User::class);
    Route::get('/users', [AdminController::class, 'getAllUsers']);
    
    Route::get('/user/{userId}/count-activities-regimes', [AdminController::class, 'countActivitiesAndRegimes']);
});*/

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
    
    //afficher tous les utilisateurs
    Route::get('/users', [AdminController::class ,'getAllUsers']);

    //nombre d'activité et regime
    Route::get('/user/{userId}/count-activities-regimes', [AdminController::class , 'countActivitiesAndRegimes']);

});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('activities/{id}', [ActivityController::class, 'show']);

    // Calculate IMC
    Route::post('/calculate-imc', [ImcController::class, 'calculateIMC']);

    // Check regime compatibility
    Route::get('/user/{userId}/imc/{imcId}/regime', [UtiregController::class, 'getUserImcAndCompatibleRegime']);

    // Check activity compatibility
    Route::get('user/{userId}/imc/{imcId}/activities', [UtiactController::class, 'getUserImcAndCompatibleActivities']);


    // Changer l'avatar ou le modifier
    Route::post('/user/upload-avatar', [AvatarController::class , 'uploadAvatar']);

    // recupérer l'avatar
    Route::get('user/get-avatar/{userId}', [AvatarController::class , 'getAvatar']);

    // recupérer l'imc de chaque utilisateur avec l'id
    //Route::get('/user/{userId}/imc',[UserController::class ,'getUserImc'] );

    // recupérer l'id de chaque utilisateur avec l'id de son imc
    Route::get('/get-user-id', [UserController::class ,'getUserId'] );

});
