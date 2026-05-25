<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contrat;
use App\Models\Vehicule;
use App\Models\ClubMembre;

class DashboardApiController extends Controller
{
    public function stats()
    {
        $derniersContrats = Contrat::with(['user', 'vehicule'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(fn($c) => [
                'id'       => $c->id,
                'client'   => $c->user->prenom . ' ' . $c->user->nom,
                'vehicule' => $c->vehicule->marque . ' ' . $c->vehicule->modele,
                'date_debut'   => $c->date_debut?->format('d/m/Y'),
                'date_fin'     => $c->date_fin_prevue?->format('d/m/Y'),
                'montant'      => number_format($c->montant_total, 2, '.', '') . ' €',
                'statut'       => $c->statut,
            ]);

        $vehiculesLoues = Contrat::with(['user', 'vehicule'])
            ->where('statut', 'en_cours')
            ->orderBy('date_fin_prevue')
            ->get()
            ->map(fn($c) => [
                'vehicule' => $c->vehicule->marque . ' ' . $c->vehicule->modele,
                'client'   => $c->user->prenom . ' ' . $c->user->nom,
                'date_fin' => 'Retour : ' . $c->date_fin_prevue?->format('d/m/Y'),
            ]);

        return response()->json([
            'nb_clients'           => User::count(),
            'nb_contrats_en_cours' => Contrat::whereIn('statut', ['en_attente','confirmee','en_cours'])->count(),
            'nb_vehicules_dispos'  => Vehicule::where('statut', 'disponible')->count(),
            'nb_membres_club'      => ClubMembre::where('actif', true)->count(),
            'derniers_contrats'    => $derniersContrats,
            'vehicules_loues'      => $vehiculesLoues,
        ]);
    }
}
