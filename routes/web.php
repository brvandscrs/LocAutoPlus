<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\VehiculeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contrats', function () {
    return view('contrats');
})->name('contrats');

Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation');

Route::post('/reservation', function () {
    return view('reservation');
})->name('reservation');

// Route::get('/vehicules', function () {
//     return view('vehicules');
// })->name('vehicules');

Route::resource('contrats', ContratController::class);
Route::resource('users', UserController::class);
Route::Resource('vehicules', VehiculeController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
