<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\CategorieVehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicule::with('categorie')->where('statut', 'disponible');

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        // Filtre par marque
        if ($request->filled('marque')) {
            $query->where('marque', 'like', '%' . $request->marque . '%');
        }

        $vehicules  = $query->get();
        $categories = CategorieVehicule::all();

        return view('vehicules.index', compact('vehicules', 'categories'));
    }

    public function show($id)
    {
        $vehicule = Vehicule::with('categorie')->findOrFail($id);

        return view('vehicules.show', compact('vehicule'));
    }
}
