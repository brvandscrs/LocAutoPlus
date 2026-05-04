<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthEmployeController;
use App\Http\Controllers\Api\ContratApiController;
use App\Http\Controllers\Api\ClubApiController;

// Authentification employé
Route::post('/employes/login', [AuthEmployeController::class, 'login']);

// Routes protégées par token Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/employes/logout', [AuthEmployeController::class, 'logout']);
    Route::post('/contrats/{id}/cloturer', [ContratApiController::class, 'cloturer']);
    Route::post('/club/verifier/{userId}', [ClubApiController::class, 'verifier']);
});
