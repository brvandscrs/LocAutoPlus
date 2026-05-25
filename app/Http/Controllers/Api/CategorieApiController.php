<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategorieVehicule;

class CategorieApiController extends Controller
{
    public function index()
    {
        $categories = CategorieVehicule::orderBy('nom')->get()->map(fn($c) => [
            'id'              => $c->id,
            'nom'             => $c->nom,
            'description'     => $c->description,
            'tarif_base_jour' => (float) $c->tarif_base_jour,
            'label'           => $c->nom . ' — ' . number_format($c->tarif_base_jour, 2) . ' €/j',
        ]);

        return response()->json(['success' => true, 'data' => $categories]);
    }
}
