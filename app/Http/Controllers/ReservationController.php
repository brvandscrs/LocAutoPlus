<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Contrat;
use App\Models\ClubMembre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function show($id)
    {
        $vehicule = Vehicule::with('categorie')->findOrFail($id);

        return view('reservation.show', compact('vehicule'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'date_debut'     => 'required|date|after_or_equal:today',
            'date_fin_prevue' => 'required|date|after:date_debut',
        ]);

        $vehicule = Vehicule::findOrFail($id);

        // Calcul du nombre de jours
        $debut = \Carbon\Carbon::parse($request->date_debut);
        $fin   = \Carbon\Carbon::parse($request->date_fin_prevue);
        $jours = $debut->diffInDays($fin);

        // Calcul du montant de base
        $montantBase = $jours * $vehicule->categorie->tarif_base_jour;

        // Vérification si le client est membre du club
        $reduction      = 0;
        $clubMembre     = ClubMembre::where('user_id', Auth::id())
                            ->where('actif', true)
                            ->with('niveau')
                            ->first();

        if ($clubMembre) {
            $reduction = $clubMembre->niveau->reduction_pct;
        }

        $montantTotal = $montantBase - ($montantBase * $reduction / 100);

        // Création du contrat
        Contrat::create([
            'user_id'             => Auth::id(),
            'vehicule_id'         => $vehicule->id,
            'date_reservation'    => now(),
            'date_debut'          => $request->date_debut,
            'date_fin_prevue'     => $request->date_fin_prevue,
            'montant_base'        => $montantBase,
            'reduction_appliquee' => $reduction,
            'montant_total'       => $montantTotal,
            'statut'              => 'en_attente',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Votre réservation a bien été enregistrée !');
    }
}
