<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load([
            'contrats.vehicule',
            'clubMembre.niveau',
            'historiquePoints',
        ]);

        $contratsEnCours = $user->contrats
            ->whereIn('statut', ['confirmee', 'en_cours'])
            ->sortByDesc('date_debut');

        $contratsTermines = $user->contrats
            ->where('statut', 'terminee')
            ->sortByDesc('date_fin_reelle');

        return view('dashboard', compact('user', 'contratsEnCours', 'contratsTermines'));
    }
}
