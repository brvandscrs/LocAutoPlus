<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contrat;
use App\Models\Vehicule;
use App\Models\ClubMembre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContratListApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Contrat::with(['user', 'vehicule.categorie', 'employe'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('user_id'))
            $query->where('user_id', $request->user_id);

        if ($request->filled('statut') && $request->statut !== 'Tous')
            $query->where('statut', $request->statut);

        $contrats = $query->get()->map(fn($c) => $this->formatContrat($c));

        return response()->json(['success' => true, 'data' => $contrats]);
    }

    public function show($id)
    {
        $c = Contrat::with(['user', 'vehicule.categorie', 'employe'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $this->formatContrat($c)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'vehicule_id'     => 'required|exists:vehicules,id',
            'date_debut'      => 'required|date',
            'date_fin_prevue' => 'required|date|after:date_debut',
        ]);

        $vehicule    = Vehicule::with('categorie')->findOrFail($request->vehicule_id);
        $debut       = \Carbon\Carbon::parse($request->date_debut);
        $fin         = \Carbon\Carbon::parse($request->date_fin_prevue);
        $jours       = $debut->diffInDays($fin);
        $montantBase = $jours * $vehicule->categorie->tarif_base_jour;

        $reduction = 0;
        $club = ClubMembre::where('user_id', $request->user_id)
            ->where('actif', true)->with('niveau')->first();
        if ($club) $reduction = $club->niveau->reduction_pct;

        $montantTotal = $montantBase - ($montantBase * $reduction / 100);

        $contrat = Contrat::create([
            'user_id'             => $request->user_id,
            'vehicule_id'         => $request->vehicule_id,
            'employe_id'          => $request->user()->id ?? null,
            'date_reservation'    => now(),
            'date_debut'          => $request->date_debut,
            'date_fin_prevue'     => $request->date_fin_prevue,
            'montant_base'        => $montantBase,
            'reduction_appliquee' => $reduction,
            'montant_total'       => $montantTotal,
            'statut'              => 'en_attente',
        ]);

        return response()->json([
            'success' => true,
            'data'    => $this->formatContrat($contrat->load(['user','vehicule.categorie','employe'])),
        ], 201);
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate(['statut' => 'required|in:en_attente,confirmee,en_cours,terminee,annulee']);
        $contrat = Contrat::findOrFail($id);
        $contrat->update(['statut' => $request->statut]);

        if ($request->statut === 'en_cours' && $request->filled('km_depart')) {
            $contrat->update([
                'km_depart'  => $request->km_depart,
                'employe_id' => $request->employe_id ?? $contrat->employe_id,
            ]);
            Vehicule::where('id', $contrat->vehicule_id)->update(['statut' => 'loue']);
        }

        if ($request->statut === 'annulee') {
            Vehicule::where('id', $contrat->vehicule_id)->update(['statut' => 'disponible']);
        }

        return response()->json(['success' => true, 'message' => 'Statut mis à jour.']);
    }

    private function formatContrat(Contrat $c): array
    {
        return [
            'id'              => $c->id,
            'client'          => $c->user->prenom . ' ' . $c->user->nom,
            'vehicule'        => $c->vehicule->marque . ' ' . $c->vehicule->modele,
            'immatriculation' => $c->vehicule->immatriculation,
            'date_debut'      => $c->date_debut?->format('d/m/Y'),
            'date_fin'        => $c->date_fin_prevue?->format('d/m/Y'),
            'date_fin_reelle' => $c->date_fin_reelle?->format('d/m/Y') ?? '—',
            'date_reservation'=> $c->date_reservation?->format('d/m/Y à H:i'),
            'montant_base'    => (float) $c->montant_base,
            'reduction'       => (float) $c->reduction_appliquee,
            'montant_total'   => (float) $c->montant_total,
            'montant_label'   => number_format($c->montant_total, 2, '.', '') . ' €',
            'statut'          => $c->statut,
            'km_depart'       => $c->km_depart ?? 0,
            'km_retour'       => $c->km_retour ?? 0,
            'notes'           => $c->notes ?? '',
            'employe'         => $c->employe ? $c->employe->prenom . ' ' . $c->employe->nom : '—',
            'user_id'         => $c->user_id,
            'vehicule_id'     => $c->vehicule_id,
        ];
    }
}
