<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthEmployeController;
use App\Http\Controllers\Api\ContratApiController;
use App\Http\Controllers\Api\ClubApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\VehiculeApiController;
use App\Http\Controllers\Api\CategorieApiController;
use App\Http\Controllers\Api\ContratListApiController;
use App\Http\Controllers\Api\EmployeApiController;

// ── Public ───────────────────────────────────────────────────────
Route::post('/employes/login', [AuthEmployeController::class, 'login']);

// ── Protégées par Sanctum ────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/employes/logout', [AuthEmployeController::class, 'logout']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardApiController::class, 'stats']);

    // Clients
    Route::get   ('/clients',      [ClientApiController::class, 'index']);
    Route::get   ('/clients/{id}', [ClientApiController::class, 'show']);
    Route::post  ('/clients',      [ClientApiController::class, 'store']);
    Route::put   ('/clients/{id}', [ClientApiController::class, 'update']);
    Route::delete('/clients/{id}', [ClientApiController::class, 'destroy']);

    // Contrats
    Route::get ('/contrats',              [ContratListApiController::class, 'index']);
    Route::get ('/contrats/{id}',         [ContratListApiController::class, 'show']);
    Route::post('/contrats',              [ContratListApiController::class, 'store']);
    Route::put ('/contrats/{id}/statut',  [ContratListApiController::class, 'updateStatut']);
    Route::post('/contrats/{id}/cloturer',[ContratApiController::class,     'cloturer']);

    // Véhicules
    Route::get   ('/vehicules',      [VehiculeApiController::class, 'index']);
    Route::get   ('/vehicules/{id}', [VehiculeApiController::class, 'show']);
    Route::post  ('/vehicules',      [VehiculeApiController::class, 'store']);
    Route::put   ('/vehicules/{id}', [VehiculeApiController::class, 'update']);
    Route::delete('/vehicules/{id}', [VehiculeApiController::class, 'destroy']);

    // Catégories
    Route::get('/categories', [CategorieApiController::class, 'index']);

    // Club
    Route::get('/club/membres',          [ClubApiController::class, 'membres']);
    Route::get('/club/niveaux',          [ClubApiController::class, 'niveaux']);
    Route::post('/club/verifier/{userId}',[ClubApiController::class, 'verifier']);

    // Employés (admin uniquement — vérification dans le controller)
    Route::get   ('/employes',           [EmployeApiController::class, 'index']);
    Route::post  ('/employes',           [EmployeApiController::class, 'store']);
    Route::put   ('/employes/{id}',      [EmployeApiController::class, 'update']);
    Route::patch ('/employes/{id}/actif',[EmployeApiController::class, 'toggleActif']);
    Route::delete('/employes/{id}',      [EmployeApiController::class, 'destroy']);

    Route::middleware('throttle:5,1')->post('/employes/login', [AuthEmployeController::class, 'login']);
});
