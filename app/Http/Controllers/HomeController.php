<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\CategorieVehicule;

class HomeController extends Controller
{
    public function index()
    {
        $vehiculesDisponibles = Vehicule::where('statut', 'disponible')
            ->with('categorie')
            ->take(6)
            ->get();

        $categories = CategorieVehicule::all();

        return view('home', compact('vehiculesDisponibles', 'categories'));
    }
}
